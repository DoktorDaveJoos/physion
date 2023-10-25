<?php

namespace App\Jobs;

use App\Models\Building;
use App\Models\Heating;
use App\Models\Prediction;
use App\Models\Renewable;
use GuzzleHttp\Client;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use OpenAI;
use Throwable;

class CreateExposePredictionsJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public int $tries = 3;
    public int $timeout = 180;

    private const MODEL = 'gpt-3.5-turbo-16k-0613';

    /**
     * Create a new job instance.
     */
    public function __construct(
        public readonly int $buildingId,
        public readonly array $tags,
    ) {
    }


    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $prompt = $this->createPrompt();

//        $client = OpenAI::client(config('openai.api_key'));
        $client = OpenAI::factory()
            ->withApiKey(config('openai.api_key'))
            ->withHttpClient(
                new Client([
                    'timeout' => 180,
                    'connect_timeout' => 180,
                ])
            )
            ->make();

        $result = $client->chat()->create([
            'model' => self::MODEL,
            'messages' => [
                [
                    'role' => 'user',
                    'content' => $this->createPrimer(),
                ],
                [
                    'role' => 'system',
                    'content' => 'Verstanden.'
                ],
                [
                    'role' => 'user',
                    'content' => $prompt,
                ],
            ],
            'max_tokens' => 5000,
        ]);

        Prediction::create([
            'building_id' => $this->buildingId,
            'type' => 'expose',
            'primer' => $this->createPrimer(),
            'prompt' => $prompt,
            'tags' => $this->tags,
            'response' => $result->choices[0]->message->content,
            'model' => self::MODEL,
        ]);

        cache()->forget('building_expose_'.$this->buildingId);
    }

    /**
     * Handle a job failure.
     * @throws Throwable
     */
    public function failed(Throwable $exception): void
    {
        cache()->forget('building_expose_'.$this->buildingId);
        throw $exception;
    }

    public function createPrompt(): string
    {
        $building = Building::find($this->buildingId);

        $prompt = "Schreibe mir ein Makler Exposè zur nachfolgenden Gebäudebeschreibung. Das Gebäude soll wohlwollend betrachtet werden aber auch Schwächen sollen als Chancen herausgearbeitet werden. Eventuell auch mögliche Sanierungsschritte:\n\n";

        $prompt .= "Straße: $building->street\n";
        $prompt .= "Hausnummer: $building->house_number\n";
        $prompt .= "Postleitzahl: $building->postal_code\n";
        $prompt .= "Stadt/Gemeinde: $building->city\n";
        $prompt .= "Haustyp: $building->type\n";
        $prompt .= "Bauart: $building->additional_type";
        $prompt .= "Wohneinheiten: $building->housing_units\n";
        $prompt .= "Wohnfläche: $building->living_area\n";

        if ($building->wall) {
            $prompt .= "Bauweise: ".$building->wall?->construction === 'massiv' ? 'Massiv' : 'Holz'."bauweise\n";
        }
        if ($building->roof) {
            $prompt .= "Dach: {$building->roof->roof_shape}, Dachgeschoss: ".$building->roof->heated ? 'beheizt' : 'unbeheizt'."\n";
        }
        if ($building->cellar) {
            $prompt .= "Keller: {$building->cellar->type}\n";
        }

        if ($building->heatings->count() > 0) {
            $building->heatings->each(function (Heating $heating, int $index) use (&$prompt) {
                $prompt .= "Heizungsanlage$index: $heating->type, $heating->system, Baujahr: $heating->construction_year.\n";
            });
        }

        if ($building->renewables->count() > 0) {
            $building->renewables->each(function (Renewable $renewable, int $index) use (&$prompt) {
                $prompt .= "Erneuerbare Energie$index: $renewable->type, $renewable->system, Baujahr: $renewable->construction_year.\n";
            });
        }

        if ($building->floor) {
            $prompt .= "Geschoss: $building->floor\n";
        }

        if ($building->land_area) {
            $prompt .= "Grundstücksfläche: $building->land_area\n";
        }

        if ($building->rooms) {
            $prompt .= "Zimmer: $building->rooms\n";
        }

        if (count($this->tags) > 0) {
            $prompt .= "Berücksichtige die folgenden Schlagworte für den Stil des Exposè: ".implode(
                    ', ',
                    $this->tags
                )."\n";
        }

//        $prompt .= "Wichtig: Das Expose soll im Format: Markdown sein.\n";

        return $prompt;
    }

    public function createPrimer(): string
    {
        $prompt = "Deine Sprache ist Deutsch. Sämtlicher Output soll in Markdown sein.\n\n";
        $prompt .= "Du bist ein Immobilienmakler. Dir ist es wichtig Vertrauen zu schaffen,\n";
        $prompt .= "deswegen weißt du auch auf Schwächen hin, wenn du sie erkennst. Allerdings möchtest du auch verkaufen,\n";
        $prompt .= "deshalb solltest du auch die Stärken des Gebäudes hervorheben.\n";
        $prompt .= "Du möchtest auch auf mögliche Sanierungsschritte hinweisen, die den Wert des Gebäudes steigern könnten.\n";
        $prompt .= "Du bist stets höflich und freundlich. Integrität und Vertrauen sind dein größtes Gut.\n";
        $prompt .= "Als Makler weißt du, dass es sich lohnt auf eine Wärmepumpe umzustellen wenn noch eine\n";
        $prompt .= "Öl- oder Gasheizung verbaut ist. Du hast gute Kenntnisse aus der Energieberatung, bist aber kein\n";
        $prompt .= "Energieberater.";

        return $prompt;
    }
}
