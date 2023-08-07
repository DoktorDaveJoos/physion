<?php

namespace App\Enums;

use App\Actions\UpdateCertificate;
use App\Actions\UpdateGeneral;
use App\Http\Requests\Certificate\Bdrf\UpdateDetailsRequest;
use App\Http\Requests\Certificate\Bdrf\UpdatePositionRequest;
use App\Http\Requests\Certificate\Bdrf\UpdateThermalRequest;
use App\Http\Requests\Certificate\Shared\SummaryRequest;
use App\Http\Requests\Certificate\Shared\UpdateGeneralRequest;
use App\Http\Requests\Certificate\Vrbr\MarkDoneConsumptionRequest;
use App\Models\Bdrf;
use App\Models\Page;
use App\Models\Vrbr;
use Exception;
use Throwable;

enum Category: string
{
    case BDRF = 'bdrf';
    case VRBR = 'vrbr';

    case BDRF_PARTNER = 'bdrf_partner';
    case VRBR_PARTNER = 'vrbr_partner';

    /**
     * Returns an instance of Bdrf or Vrbr.
     * @return Bdrf|Vrbr
     */
    public function getModel(): Vrbr|Bdrf
    {
        return match ($this) {
            self::BDRF, self::BDRF_PARTNER => self::getModelInstance(Bdrf::class),
            self::VRBR, self::VRBR_PARTNER => self::getModelInstance(Vrbr::class),
        };
    }

    /**
     * Returns an instance of the model.
     * @template T
     * $param class-string<T> $model
     * @return T
     */
    public static function getModelInstance(string $model): object
    {
        return new $model();
    }

    public static function fromValue(string $value): self
    {
        return match ($value) {
            self::BDRF->value, self::BDRF_PARTNER->value => self::BDRF,
            self::VRBR->value, self::VRBR_PARTNER->value => self::VRBR,
        };
    }


    /**
     * Returns the Category::case for the model.
     *
     * @param class-string<Vrbr::class, Bdrf::class> $classString
     * @return Category
     *
     * @throws Throwable
     */
    public static function fromModel(string $classString): Category
    {
        if (request()?->user()?->id) {
            return match ($classString) {
                Bdrf::class => self::BDRF_PARTNER,
                Vrbr::class => self::VRBR_PARTNER,
                default => throw new Exception('Invalid category'),
            };
        }

        return match ($classString) {
            Bdrf::class => self::BDRF,
            Vrbr::class => self::VRBR,
            default => throw new Exception('Invalid category'),
        };
    }

    public function eligibleForUpdate(): array
    {
        return match ($this) {
            self::BDRF, self::VRBR, self::VRBR_PARTNER, self::BDRF_PARTNER => ['created', 'finalized', 'in_clarification'],
        };
    }

    public function getAvailablePageKeys(): array
    {
        return array_keys($this->getAvailablePages());
    }

    public function pageExists(string $page): bool
    {
        return in_array($page, $this->getAvailablePageKeys());
    }

    public function getPage(string $key): Page
    {
        return $this->getAvailablePages()[$key];
    }

    public function getNextPageAfter(string $page): false|string
    {
        // Get the string keys of the pages and flatten them to get
        // numbered indexes.
        $pages = array_keys($this->getAvailablePages());

        $index = array_search($page, $pages, true);

        // If the page is the last page, return false
        if ($index === count($this->getAvailablePageKeys()) - 1) {
            return false;
        }

        $nextIndex = $index + 1;

        return $pages[$nextIndex];
    }

    public function getVueComponent(string $key, bool $hub = false): string
    {
        return $this->getPage($key)->getVueComponent($hub);
    }

    /**
     * @throws Throwable
     */
    public function getFormRequest(string $page): object
    {
        throw_if(
            !$this->getPage($page)->getFormRequest(),
            new Exception('No form request defined for this page.')
        );

        return self::getModelInstance($this->getPage($page)->getFormRequest());
    }

    /**
     * @throws Throwable
     */
    public function getAction(string $page): object
    {
        throw_if(
            !$this->getPage($page)->getAction(),
            new Exception('No action defined for this page.')
        );

        return self::getModelInstance($this->getPage($page)->getAction());
    }

    /**
     * Returns an array of available pages for the certificate.
     * @return array<string, Page>
     */
    public function getAvailablePages(): array
    {
        return match ($this) {
            self::BDRF, self::BDRF_PARTNER => [
                'general' => Page::make(
                    'Allgemein',
                    'Allgemeine Angaben zum Gebäude',
                    'Certificate/Shared/General',
                    UpdateGeneralRequest::class,
                    UpdateGeneral::class
                ),
                'details' => Page::make(
                    'Details',
                    'Details zum Gebäude',
                    'Certificate/Shared/Details',
                    UpdateDetailsRequest::class,
                    UpdateCertificate::class
                ),
                'position' => Page::make(
                    'Lage',
                    'Lage des Gebäudes',
                    'Certificate/Bdrf/Position',
                    UpdatePositionRequest::class,
                    UpdateCertificate::class
                ),
                'thermal' => Page::make(
                    'Thermische Hülle',
                    'Thermische Hülle des Gebäudes',
                    'Certificate/Bdrf/Thermal',
                    UpdateThermalRequest::class,
                    UpdateCertificate::class
                ),
                'energy' => Page::make(
                    'Energie',
                    'Heizung und Energiegewinnung des Gebäudes',
                    'Certificate/Bdrf/Energy',
                    UpdateThermalRequest::class,
                    UpdateCertificate::class
                ),
                'summary' => Page::make(
                    'Zusammenfassung',
                    'Zusammenfassung der Angaben',
                    'Certificate/Bdrf/Summary',
                    SummaryRequest::class,
                    UpdateCertificate::class
                ),
            ],
            self::VRBR, self::VRBR_PARTNER => [
                'general' => Page::make(
                    'Allgemein',
                    'Allgemeine Angaben zum Gebäude',
                    'Certificate/Shared/General',
                    UpdateGeneralRequest::class,
                    UpdateGeneral::class
                ),
                'details' => Page::make(
                    'Details',
                    'Details zum Gebäude',
                    'Certificate/Shared/Details',
                    \App\Http\Requests\Certificate\Vrbr\UpdateDetailsRequest::class,
                    UpdateCertificate::class
                ),
                'consumption' => Page::make(
                    'Verbrauch',
                    'Verbrauch des Gebäudes',
                    'Certificate/Vrbr/Consumption',
                    MarkDoneConsumptionRequest::class,
                    UpdateCertificate::class
                ),
                'summary' => Page::make(
                    'Zusammenfassung',
                    'Abschluss und Checkout',
                    'Certificate/Vrbr/Summary',
                    SummaryRequest::class,
                    UpdateCertificate::class
                ),
            ],
        };
    }

}
