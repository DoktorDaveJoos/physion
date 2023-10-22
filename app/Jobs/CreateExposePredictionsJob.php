<?php

namespace App\Jobs;

use AllowDynamicProperties;
use App\Models\Building;
use App\Models\Prediction;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use OpenAI;

class CreateExposePredictionsJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private const MODEL = 'gpt-4';

    /**
     * Create a new job instance.
     */
    public function __construct(public readonly int $buildingId)
    {
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $building = Building::find($this->buildingId);

        $prompt = "Schreibe mir ein Maklerexpose zur nachfolgenden Gebäudebeschreibung,das Gebäude soll wohlwollend betrachtet werden aber auch schwächen sollen als chancen herausgearbeitet werden. Eventuell auch mögliche Sanierungsschritte:\n\n";
        $prompt .= "Straße: {$building->street}\n";
        $prompt .= "Hausnummer: {$building->house_number}\n";
        $prompt .= "Postleitzahl: {$building->postal_code}\n";
        $prompt .= "Stadt/Gemeinde: {$building->city}\n";
        $prompt .= "Haustyp: {$building->type}\n";
        $prompt .= "Bauart: {$building->additional_type}, " . $building->wall?->construction === 'massiv' ? 'Massiv' : 'Holz' . "\n";
        $prompt .= "Wohneinheiten: {$building->housing_units}\n";
        $prompt .= "Keller: {$building->cellar}\n";
        $prompt .= "Bau: {$building->roof->roof_shape}\n";
        $prompt .= "Baujahr Energieträger: {$building->construction_year_heating}\n";
        $prompt .= "Wohnfläche: {$building->living_area}\n";
//        $prompt .= "Grundstücksfläche: {$building->plot_area}\n";
//        $prompt .= "Zimmer: {$building->rooms}\n";
        $prompt .= "Etagen: {$building->floors}\n";
//        $prompt .= "Kaufpreis: {$building->price}\n";
//        $prompt .= "Kaltmiete: {$building->cold_rent}\n";
        $prompt .= "Heizungsanlage(n): " . implode(', ', $building->heatings->pluck('name')->toArray()) . "\n";
        $prompt .= "Erneuerbare Energie(n): " . implode(', ', $building->renewables->pluck('name')->toArray()) . "\n";
//        $prompt .= "Energieausweis: {$building->energy_certificate->rating}\n";
        $prompt .= "Der Stil des Exposé soll nüchtern sein. Das Expose soll im Format: Markdown sein.\n";

        $client = OpenAI::client(config('openai.api_key'));

        $result = $client->chat()->create([
            'model' => self::MODEL,
            'messages' => [
                [
                    'role' => 'user',
                    'content' => $prompt
                ]
            ],
            'max_tokens' => 2000,
        ]);

        Prediction::create([
            'building_id' => $this->buildingId,
            'type' => 'expose',
            'prompt' => $prompt,
            'response' => $result->choices[0]->message->content,
            'model' => self::MODEL,
        ]);

        cache()->forget('building_expose_' . $this->buildingId);
    }
}
