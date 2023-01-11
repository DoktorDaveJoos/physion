<?php

namespace Database\Seeders;

use App\Models\BlogEntry;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BlogSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $entries = [
            [
                'title' => 'Was ist ein Energieausweis?',
                'slug' => 'was-ist-ein-energieausweis',
                'user_id' => 2,
                'content' => '<p>Ein Energieausweis ist ein Dokument, das die Energieeffizienz eines Gebäudes beschreibt. In Deutschland ist es für bestimmte Gebäude vorgeschrieben, einen Energieausweis zu besitzen. Der Energieausweis enthält Informationen über den Energiebedarf des Gebäudes und den CO2-Ausstoß.</p> 
<p>In einem Energieausweis müssen folgende Angaben enthalten sein:</p> 
<ol> 
<li>Das Baujahr des Gebäudes</li> 
<li>Die Art des Gebäudes (z.B. Einfamilienhaus, Mehrfamilienhaus, Bürogebäude)</li> 
<li>Die Art der Heizung (z.B. Ölheizung, Gasheizung, Wärmepumpe)</li> 
<li>Die Art der Fenster (z.B. Isolierglasfenster, Kunststofffenster)</li> 
<li>Die Art der Dämmung (z.B. Dachdämmung, Wanddämmung)</li> 
<li>Die Größe des Gebäudes in Quadratmetern</li> 
<li>Der Energiebedarf des Gebäudes in Kilowattstunden pro Quadratmeter und Jahr</li> 
<li>Der CO2-Ausstoß des Gebäudes in Kilogramm pro Quadratmeter und Jahr</li> 
</ol> 
<p>Der Energieausweis wird von einem Energieberater erstellt, der das Gebäude untersucht und die oben genannten Angaben ermittelt. Der Energieausweis wird dann in einer von der Bundesregierung festgelegten Form ausgestellt und kann von Interessenten eingesehen werden, z.B. beim Verkauf oder bei der Vermietung eines Gebäudes.</p> 
<p>Der Gültigkeitszeitraum eines Energieausweises hängt davon ab, welche Art von Energieausweis es ist und für welches Gebäude er ausgestellt wurde.</p> 
<p>Für Wohngebäude gibt es zwei Arten von Energieausweisen: den Bedarfsausweis und den Verbrauchsausweis. Der Bedarfsausweis gibt den voraussichtlichen Energiebedarf eines Gebäudes an und ist 10 Jahre gültig. Der Verbrauchsausweis gibt den tatsächlichen Energieverbrauch eines Gebäudes an und ist nur für einen Zeitraum von fünf Jahren gültig.</p> 
<p>Für Nichtwohngebäude gibt es auch den Bedarfsausweis, der 10 Jahre gültig ist, und den Verbrauchsausweis, der nur für einen Zeitraum von drei Jahren gültig ist.</p>

<p>Es ist wichtig zu beachten, dass Energieausweise regelmäßig aktualisiert werden müssen, wenn sich an den Eigenschaften des Gebäudes etwas ändert, das die Energieeffizienz beeinflussen könnte, z.B. der Austausch von Fenstern oder die Installation von Dämmung. In solchen Fällen muss ein neuer Energieausweis ausgestellt werden, der die aktualisierten Angaben enthält.</p>',
                'published' => true,
                'published_at' => Carbon::parse('2022-06-04'),
                'short_description' => 'Ein Energieausweis ist ein Dokument, das die Energieeffizienz eines Gebäudes beschreibt. In Deutschland ist es für bestimmte Gebäude vorgeschrieben, einen Energieausweis zu besitzen. Der Energieausweis enthält Informationen über den Energiebedarf des Gebäudes und den CO2-Ausstoß.',
            ],
            [
                'title' => 'Brauche ich ein Foto meines Gebäudes?',
                'slug' => 'brauche-ich-ein-foto-meines-gebaeudes',
                'user_id' => 2,
                'content' => '<p>Es ist nicht üblich, dass ein Foto des Gebäudes im Energieausweis enthalten ist. Der Energieausweis enthält in der Regel Informationen über den Energiebedarf und den CO2-Ausstoß des Gebäudes, das Baujahr, die Art des Gebäudes, die Art der Heizung, die Art der Fenster und die Art der Dämmung. Diese Informationen werden von einem Energieberater erhoben, der das Gebäude untersucht und die Angaben in einem von der Bundesregierung festgelegten Formular festhält.
</p><p>Ein Foto des Gebäudes könnte zwar dazu beitragen, einen besseren Eindruck von der Größe und den äußeren Eigenschaften des Gebäudes zu vermitteln, ist aber für die Bewertung der Energieeffizienz des Gebäudes in der Regel nicht erforderlich. Es gibt jedoch Fälle, in denen ein Foto des Gebäudes in Verbindung mit dem Energieausweis genutzt wird, z.B. bei der Erstellung von Visualisierungen oder bei der Präsentation von Modernisierungsmaßnahmen. In solchen Fällen kann es sinnvoll sein, ein Foto des Gebäudes beizufügen, um einen besseren Eindruck von den Veränderungen zu vermitteln.</p>',
                'published' => true,
                'published_at' => Carbon::parse('2022-06-16'),
                'short_description' => 'Es ist nicht üblich, dass ein Foto des Gebäudes im Energieausweis enthalten ist. Der Energieausweis enthält in der Regel Informationen über den Energiebedarf und den CO2-Ausstoß des Gebäudes, das Baujahr, die Art des Gebäudes, die Art der Heizung, die Art der Fenster und die Art der Dämmung.',
            ],
            [
                'title' => 'Energieausweis nach GEG',
                'slug' => 'energieausweis-nach-geg',
                'user_id' => 2,
                'content' => '<p>Der Energieausweis nach GEG (Gebäude-Energie-Gesetz) ist ein Dokument, das die Energieeffizienz eines Gebäudes beschreibt. In Deutschland ist es für bestimmte Gebäude vorgeschrieben, einen Energieausweis zu besitzen. Der Energieausweis enthält Informationen über den Energiebedarf des Gebäudes und den CO2-Ausstoß.</p>
                <p>Der Energieausweis nach GEG wird von einem Energieberater erstellt, der das Gebäude untersucht und die oben genannten Angaben ermittelt. Der Energieausweis wird dann in einer von der Bundesregierung festgelegten Form ausgestellt und kann von Interessenten eingesehen werden, z.B. beim Verkauf oder bei der Vermietung eines Gebäudes.</p>
                <p>Es gibt zwei Arten von Energieausweisen nach GEG: den Bedarfsausweis und den Verbrauchsausweis. Der Bedarfsausweis gibt den voraussichtlichen Energiebedarf eines Gebäudes an und ist 10 Jahre gültig. Der Verbrauchsausweis gibt den tatsächlichen Energieverbrauch eines Gebäudes an und ist nur für einen Zeitraum von fünf Jahren gültig.</p>
                <p>Es ist wichtig zu beachten, dass Energieausweise nach GEG regelmäßig aktualisiert werden müssen, wenn sich an den Eigenschaften des Gebäudes etwas ändert, das die Energieeffizienz beeinflussen könnte, z.B. der Austausch von Fenstern oder die Installation von Dämmung. In solchen Fällen muss ein neuer Energieausweis ausgestellt werden, der die aktualisierten Angaben enthält.</p>
                ',
                'published' => true,
                'published_at' => Carbon::parse('2022-06-20'),
                'short_description' => 'Der Energieausweis nach GEG (Gebäude-Energie-Gesetz) ist ein Dokument, das die Energieeffizienz eines Gebäudes beschreibt. In Deutschland ist es für bestimmte Gebäude vorgeschrieben, einen Energieausweis zu besitzen. Der Energieausweis enthält Informationen über den Energiebedarf des Gebäudes und den CO2-Ausstoß.',
            ],
            [
                'title' => 'Energieausweis nach EnEV',
                'slug' => 'energieausweis-nach-enev',
                'user_id' => 2,
                'content' => '<p>Der Energieausweis nach EnEV (Energieeinsparverordnung) ist ein Dokument, das die Energieeffizienz eines Gebäudes beschreibt. In Deutschland ist es für bestimmte Gebäude vorgeschrieben, einen Energieausweis zu besitzen. Der Energieausweis enthält Informationen über den Energiebedarf des Gebäudes und den CO2-Ausstoß.</p>
                <p>Der Energieausweis nach EnEV wird von einem Energieberater erstellt, der das Gebäude untersucht und die oben genannten Angaben ermittelt. Der Energieausweis wird dann in einer von der Bundesregierung festgelegten Form ausgestellt und kann von Interessenten eingesehen werden, z.B. beim Verkauf oder bei der Vermietung eines Gebäudes.</p>
                <p>Es gibt zwei Arten von Energieausweisen nach EnEV: den Bedarfsausweis und den Verbrauchsausweis. Der Bedarfsausweis gibt den voraussichtlichen Energiebedarf eines Gebäudes an und ist 10 Jahre gültig. Der Verbrauchsausweis gibt den tatsächlichen Energieverbrauch eines Gebäudes an und ist nur für einen Zeitraum von fünf Jahren gültig.</p>
                <p>Es ist wichtig zu beachten, dass Energieausweise nach EnEV regelmäßig aktualisiert werden müssen, wenn sich an den Eigenschaften des Gebäudes etwas ändert, das die Energieeffizienz beeinflussen könnte, z.B. der Austausch von Fenstern oder die Installation von Dämmung. In solchen Fällen muss ein neuer Energieausweis ausgestellt werden, der die aktualisierten Angaben enthält.</p>
                ',
                'published' => true,
                'published_at' => Carbon::parse('2022-06-21'),
                'short_description' => 'Der Energieausweis nach EnEV (Energieeinsparverordnung) ist ein Dokument, das die Energieeffizienz eines Gebäudes beschreibt. In Deutschland ist es für bestimmte Gebäude vorgeschrieben, einen Energieausweis zu besitzen. Der Energieausweis enthält Informationen über den Energiebedarf des Gebäudes und den CO2-Ausstoß.',
            ],
            [
                'title' => 'Was ist die ENEV?',
                'slug' => 'was-ist-die-enev',
                'user_id' => 2,
                'content' => '
                <p>Die Energieeinsparverordnung (ENEV) ist eine gesetzliche Regelung in Deutschland, die festlegt, wie energieeffizient Neubauten und sanierten Gebäude sein müssen. Die ENEV enthält Anforderungen an die Dämmung von Gebäuden, die Heizungsanlagen und die Fenster und gibt vor, wie viel Energie ein Gebäude maximal verbrauchen darf.</p>
                <p>Die ENEV wurde erstmals 2002 verabschiedet und seitdem mehrfach überarbeitet. Die aktuelle ENEV trat am 1. Januar 2016 in Kraft und wurde zuletzt im Jahr 2020 angepasst. Die ENEV dient dazu, den Energieverbrauch von Gebäuden zu reduzieren und damit den CO2-Ausstoß zu senken. Sie ist Teil der nationalen Energiepolitik und soll dazu beitragen, die Klimaziele der EU und Deutschlands zu erreichen.</p>
                <p>Die ENEV betrifft sowohl Neubauten als auch Sanierungen von bestehenden Gebäuden. Für Neubauten gibt sie feste Grenzwerte für den Energiebedarf vor, die eingehalten werden müssen. Für Sanierungen gibt sie vor, dass der Energiebedarf nach der Sanierung nicht höher sein darf als vor der Sanierung. Die ENEV wird regelmäßig angepasst, um den Fortschritt in der Energieeffizienz zu berücksichtigen und die Anforderungen an die Energieeffizienz zu erhöhen.</p>
                ',
                'published' => true,
                'published_at' => Carbon::parse('2022-07-10'),
                'short_description' => 'Die Energieeinsparverordnung (ENEV) ist eine gesetzliche Regelung in Deutschland, die festlegt, wie energieeffizient Neubauten und sanierten Gebäude sein müssen. Die ENEV enthält Anforderungen an die Dämmung von Gebäuden, die Heizungsanlagen und die Fenster und gibt vor, wie viel Energie ein Gebäude maximal verbrauchen darf.',
            ],
            [
                'title' => 'Verbrauchsausweis',
                'slug' => 'verbrauchsausweis',
                'user_id' => 2,
                'content' => '
                <p>Ein Verbrauchsausweis ist ein Dokument, das Informationen über den Energieverbrauch und die Energieeffizienz eines Gebäudes enthält. Der Verbrauchsausweis wird in der Regel für Wohngebäude erstellt und gibt Auskunft über den jährlichen Energieverbrauch des Gebäudes in Kilowattstunden pro Quadratmeter (kWh/m²). Der Verbrauchsausweis wird auf der Grundlage von Tests und Berechnungen erstellt, die den Energiebedarf des Gebäudes ermitteln.</p>
                <p>Der Verbrauchsausweis dient dazu, den Energieverbrauch eines Gebäudes transparent zu machen und damit die Möglichkeit zu bieten, den Energieverbrauch zu optimieren und Energiekosten zu senken. Er kann auch als Entscheidungshilfe für den Kauf oder die Miete von Wohnungen oder Häusern dienen, da er Auskunft darüber gibt, wie energieeffizient das Gebäude ist. In Deutschland ist es seit 2007 gesetzlich vorgeschrieben, dass bei der Vermietung oder Verkauf von Wohngebäuden ein Verbrauchsausweis vorgelegt werden muss.</p>
                ',
                'published' => true,
                'published_at' => Carbon::parse('2022-07-20'),
                'short_description' => 'Ein Verbrauchsausweis ist ein Dokument, das Informationen über den Energieverbrauch und die Energieeffizienz eines Gebäudes enthält. Der Verbrauchsausweis wird in der Regel für Wohngebäude erstellt und gibt Auskunft über den jährlichen Energieverbrauch des Gebäudes in Kilowattstunden pro Quadratmeter (kWh/m²). Der Verbrauchsausweis wird auf der Grundlage von Tests und Berechnungen erstellt, die den Energiebedarf des Gebäudes ermitteln.',
            ],
            [
                'title' => 'Bedarfsausweis',
                'slug' => 'bedarfsausweis',
                'user_id' => 2,
                'content' => '
                <p>Ein Bedarfsausweis ist ein Dokument, das Informationen über den Energiebedarf eines Gebäudes enthält. Der Bedarfsausweis wird in der Regel für Wohngebäude erstellt und gibt Auskunft über den jährlichen Energiebedarf des Gebäudes in Kilowattstunden pro Quadratmeter (kWh/m²). Der Bedarfsausweis wird auf der Grundlage von Tests und Berechnungen erstellt, die den Energiebedarf des Gebäudes ermitteln.</p>
                <p>Im Gegensatz zum Verbrauchsausweis, der den tatsächlichen Energieverbrauch eines Gebäudes anzeigt, gibt der Bedarfsausweis den voraussichtlichen Energiebedarf eines Gebäudes an. Dazu werden verschiedene Faktoren berücksichtigt, wie zum Beispiel die Dämmung des Gebäudes, die Heizungsanlage und die Fenster. Der Bedarfsausweis dient dazu, den Energiebedarf eines Gebäudes transparent zu machen und damit die Möglichkeit zu bieten, den Energieverbrauch zu optimieren und Energiekosten zu senken. Er kann auch als Entscheidungshilfe für den Kauf oder die Miete von Wohnungen oder Häusern dienen, da er Auskunft darüber gibt, wie energieeffizient das Gebäude ist. In Deutschland ist es seit 2007 gesetzlich vorgeschrieben, dass bei der Vermietung oder Verkauf von Wohngebäuden entweder ein Verbrauchsausweis oder ein Bedarfsausweis vorgelegt werden muss.</p>
                ',
                'published' => true,
                'published_at' => Carbon::parse('2022-07-31'),
                'short_description' => 'Ein Bedarfsausweis ist ein Dokument, das Informationen über den Energiebedarf eines Gebäudes enthält. Der Bedarfsausweis wird in der Regel für Wohngebäude erstellt und gibt Auskunft über den jährlichen Energiebedarf des Gebäudes in Kilowattstunden pro Quadratmeter (kWh/m²). Der Bedarfsausweis wird auf der Grundlage von Tests und Berechnungen erstellt, die den Energiebedarf des Gebäudes ermitteln.',
            ],
            [
                'title' => 'Brauchen auch Passivhäuser einen Energieausweis?',
                'slug' => 'brauchen-auch-passivhaeuser-einen-energieausweis',
                'user_id' => 2,
                'content' => '
                <p>Passivhäuser sind Gebäude, die besonders energieeffizient sind und in denen der Energiebedarf sehr gering ist. Passivhäuser werden in der Regel ohne konventionelle Heizsysteme betrieben und erreichen ihre Wärmebedarfe durch die Nutzung von Sonnenenergie und der Wärmeabgabe von Haushaltsgeräten und Personen.</p>
                <p>Grundsätzlich sind auch Passivhäuser von der gesetzlichen Pflicht betroffen, einen Energieausweis vorzulegen, wenn das Gebäude verkauft oder vermietet wird oder wenn es zu einer wesentlichen Änderung der Nutzung des Gebäudes kommt. Der Energieausweis dient dazu, die Energieeffizienz des Gebäudes zu dokumentieren und den zukünftigen Nutzern Auskunft über die Energiekosten zu geben.</p>
                <p>Es gibt jedoch Ausnahmen von dieser Regel, z.B. wenn das Passivhaus in einem sogenannten "Sanierungsgebiet" liegt oder wenn es gefördert wird. In solchen Fällen kann es erforderlich sein, dass ein Energieausweis vorgelegt wird, um die Energieeffizienz des Gebäudes zu dokumentieren und um die Förderung zu beantragen.</p>
                <p>Es empfiehlt sich daher, sich beim Kauf oder Verkauf eines Passivhauses an einen Energieberater oder das zuständige Baurechtsamt zu wenden, um sicherzustellen, dass alle erforderlichen Unterlagen und Nachweise vorliegen.</p>
                ',
                'published' => true,
                'published_at' => Carbon::parse('2022-08-01'),
                'short_description' => 'Passivhäuser sind Gebäude, die besonders energieeffizient sind und in denen der Energiebedarf sehr gering ist. Passivhäuser werden in der Regel ohne konventionelle Heizsysteme betrieben und erreichen ihre Wärmebedarfe durch die Nutzung von Sonnenenergie und der Wärmeabgabe von Haushaltsgeräten und Personen.',
            ],
            [
                'title' => 'Energieausweis verloren was tun?',
                'slug' => 'energieausweis-verloren-was-tun',
                'user_id' => 2,
                'content' => '
                    <p>Energieausweis verloren? Kein Problem! Mit Bauzertifikate.de müssen Sie sich nie wieder Sorgen machen, Ihren Energieausweis zu verlieren. Unser Unternehmen speichert Ihren Energieausweis kostenlos während der gesamten Gültigkeitsdauer und stellt ihn Ihnen jederzeit auf Anfrage zur Verfügung.</p>
                    <p>Der Energieausweis ist ein wichtiges Dokument, das die Energieeffizienz eines Gebäudes dokumentiert und Auskunft über die Energiekosten gibt. Bei Bauzertifikate.de wissen wir, wie wichtig es ist, den Energieausweis immer griffbereit zu haben, insbesondere wenn das Gebäude verkauft oder vermietet wird oder wenn es zu einer wesentlichen Änderung der Nutzung des Gebäudes kommt.</p>
                    <p>Im Vergleich zu anderen Anbietern müssen Sie sich bei uns nie wieder Gedanken darüber machen, Ihren Energieausweis zu verlieren. Wir speichern ihn sicher und zugänglich für Sie, damit Sie sich auf das konzentrieren können, was wirklich wichtig ist - Ihr Gebäude. Entscheiden Sie sich für Bauzertifikate.de, wenn Sie einen neuen Energieausweis beantragen oder Ihren bestehenden Energieausweis aktualisieren müssen.</p>
                ',
                'published' => true,
                'published_at' => Carbon::parse('2022-09-02'),
                'short_description' => 'Energieausweis verloren? Kein Problem! Mit Bauzertifikate.de müssen Sie sich nie wieder Sorgen machen, Ihren Energieausweis zu verlieren. Unser Unternehmen speichert Ihren Energieausweis kostenlos während der gesamten Gültigkeitsdauer und stellt ihn Ihnen jederzeit auf Anfrage zur Verfügung.',
            ],
            [
                'title' => 'Warum Endenergiebedarf und Primärenergiebedarf im Energieausweis?',
                'slug' => 'warum-endenergiebedarf-und-primaerenergiebedarf-im-energieausweis',
                'user_id' => 2,
                'content' => '
                <p>Der Primärenergiebedarf eines Gebäudes ist der Energiebedarf, der zur Deckung des Energiebedarfs eines Gebäudes erforderlich ist. Er umfasst den Energiebedarf für Heizung, Warmwasser, Lüftung, Beleuchtung und elektrischen Strom. Der Primärenergiebedarf wird in Kilowattstunden pro Quadratmeter und Jahr (kWh/m²a) angegeben.</p>
                <p>Der Endenergiebedarf eines Gebäudes ist der tatsächlich benötigte Energiebedarf, um das Gebäude zu beheizen und mit Warmwasser und Strom zu versorgen. Er wird in Kilowattstunden pro Quadratmeter und Jahr (kWh/m²a) angegeben und umfasst den Energiebedarf für Heizung, Warmwasser, Lüftung, Beleuchtung und elektrischen Strom.</p>
                <p>Der Unterschied zwischen Primärenergiebedarf und Endenergiebedarf liegt in der Art der Energieträger, die zur Deckung des Energiebedarfs eingesetzt werden. Der Primärenergiebedarf bezieht sich auf den Energiebedarf, der zur Deckung des Energiebedarfs erforderlich ist, ohne Rücksicht auf die Art der Energieträger. Der Endenergiebedarf hingegen bezieht sich auf den tatsächlich benötigten Energiebedarf, der sich aus dem Primärenergiebedarf und dem Wirkungsgrad der Energieträger ergibt.</p>
                <p>Beispiel: Wenn ein Gebäude mit Öl geheizt wird, ist der Primärenergiebedarf der Energiebedarf, der zur Deckung des Energiebedarfs erforderlich ist, wenn das Öl direkt verbrennt. Der Endenergiebedarf hingegen bezieht sich auf den tatsächlich benötigten Energiebedarf, der sich aus dem Primärenergiebedarf und dem Wirkungsgrad der Ölheizung ergibt. Wenn die Ölheizung z.B. einen Wirkungsgrad von 90 % hat, bedeutet dies, dass 90 % der im Öl enthaltenen Energie in Wärme umgewandelt werden und 10 % als Abwärme verloren gehen. Der Endenergiebedarf wird daher um 10 % höher sein als der Primärenergiebedarf.</p>
                ',
                'published' => true,
                'published_at' => Carbon::parse('2022-10-03'),
                'short_description' => 'Der Primärenergiebedarf eines Gebäudes ist der Energiebedarf, der zur Deckung des Energiebedarfs eines Gebäudes erforderlich ist. Er umfasst den Energiebedarf für Heizung, Warmwasser, Lüftung, Beleuchtung und elektrischen Strom. Der Primärenergiebedarf wird in Kilowattstunden pro Quadratmeter und Jahr (kWh/m²a) angegeben.',
            ],
            [
                'title' => 'Was ist der Unterschied zwischen Energieausweis und Energiepass?',
                'slug' => 'was-ist-der-unterschied-zwischen-energieausweis-und-energiepass',
                'user_id' => 2,
                'content' => '
                <p>Es besteht kein Unterschied zwischen Energieausweis und Energiesparpass. Beide Dokumente haben denselben Zweck und werden von den Behörden als gleichwertig anerkannt. Der Energieausweis wird jedoch häufiger verwendet, da er in der Regel für alle Gebäude erforderlich ist, die verkauft oder vermietet werden. Der Energiesparpass wird hauptsächlich für Gebäude verwendet, die neu gebaut oder umgebaut werden.</p>
                ',
                'published' => true,
                'published_at' => Carbon::parse('2022-11-04'),
                'short_description' => 'Es besteht kein Unterschied zwischen Energieausweis und Energiesparpass. Beide Dokumente haben denselben Zweck und werden von den Behörden als gleichwertig anerkannt. Der Energieausweis wird jedoch häufiger verwendet, da er in der Regel für alle Gebäude erforderlich ist, die verkauft oder vermietet werden. Der Energiesparpass wird hauptsächlich für Gebäude verwendet, die neu gebaut oder umgebaut werden.',
            ],
            [
                'title' => 'Worst Performing Building',
                'slug' => 'worst-performing-building',
                'user_id' => 2,
                'content' => '
                <p>Ein Gebäude wird als "worst performing building" (englisch für "schlechtestes Gebäude") bezeichnet, wenn es einen sehr hohen Energieverbrauch hat und damit sehr ineffizient ist. Dies bedeutet, dass das Gebäude viel mehr Energie benötigt, als es bei einer optimalen Auslegung und Nutzung eines Gebäudes üblich wäre.</p>
                <p>Es gibt verschiedene Gründe, warum ein Gebäude als worst performing building bezeichnet werden kann. Zum Beispiel könnte das Gebäude unzureichend gedämmt sein, was zu hohen Heizkosten führen kann. Auch eine ineffiziente Heizungsanlage oder ungünstig orientierte Fenster können dazu beitragen, dass ein Gebäude als worst performing building bezeichnet wird.</p>
                <p>Um ein Gebäude als worst performing building zu identifizieren, werden in der Regel Tests und Berechnungen durchgeführt, die den Energiebedarf und -verbrauch des Gebäudes ermitteln. Dazu können zum Beispiel eine Heizlastberechnung, eine Dichtheitsprüfung oder ein Blower-Door-Test durchgeführt werden. Auf der Grundlage dieser Tests und Berechnungen kann festgestellt werden, ob ein Gebäude als worst performing building bezeichnet werden kann und wo Verbesserungspotentiale liegen.</p>
                <p>Welchen Vorteil habe ich bei einer Sanierung, wenn das Gebäude ein Worst Performing Building ist?</p>
                <p>Eine Sanierung eines Gebäudes, das als "worst performing building" (englisch für "schlechtestes Gebäude") bezeichnet wird, kann viele Vorteile haben. Zunächst einmal kann eine Sanierung dazu beitragen, den Energieverbrauch des Gebäudes zu reduzieren und damit die Energiekosten zu senken. Je höher der Energieverbrauch eines Gebäudes ist, desto größer ist in der Regel auch das Einsparpotential durch eine Sanierung.</p>
                <p>Eine Sanierung eines worst performing Buildings kann auch dazu beitragen, den Wohnkomfort im Gebäude zu verbessern. Zum Beispiel können durch eine bessere Dämmung kalte Wände und Fenster vermieden werden, und durch eine moderne Heizungsanlage kann die Raumtemperatur besser reguliert werden.</p>
                <p>Darüber hinaus kann eine Sanierung eines worst performing Buildings auch ökologische Vorteile haben. Durch den geringeren Energieverbrauch werden weniger CO2-Emissionen verursacht, was zum Schutz der Umwelt beitragen kann.</p>
                <p>Schließlich kann eine Sanierung eines worst performing Buildings auch zu einer Wertsteigerung des Gebäudes beitragen. Ein energieeffizientes Gebäude ist in der Regel attraktiver für potenzielle Mieter oder Käufer, wodurch der Wert des Gebäudes gesteigert werden kann.</p>
                ',
                'published' => true,
                'published_at' => Carbon::parse('2022-12-07'),
                'short_description' => 'Ein Gebäude wird als "worst performing building" (englisch für "schlechtestes Gebäude") bezeichnet, wenn es einen sehr hohen Energieverbrauch hat und damit sehr ineffizient ist. Dies bedeutet, dass das Gebäude viel mehr Energie benötigt, als es bei einer optimalen Auslegung und Nutzung eines Gebäudes üblich wäre.',
            ],
            [
                'title' => 'Förderung, Energieausweis und Worst Performing Building',
                'slug' => 'foerderung-energieausweis-und-worst-performing-building',
                'user_id' => 2,
                'content' => '
                <p>Es kann sein, dass Sie für die Sanierung eines worst performing Buildings mehr Förderung bekommen, da solche Gebäude in der Regel ein größeres Einsparpotential haben und damit eine höhere Förderung gerechtfertigt ist. Allerdings hängt die Höhe der Förderung, die Sie für eine Sanierung bekommen, von verschiedenen Faktoren ab, wie zum Beispiel dem Bundesland, in dem das Gebäude liegt, den Sanierungsmaßnahmen, die durchgeführt werden, und Ihrem persönlichen Einkommen.</p>
                <p>Um herauszufinden, ob und inwieweit Sie für die Sanierung eines worst performing Buildings Förderung bekommen können, sollten Sie sich an Ihr zuständiges Förderinstitut wenden. In Deutschland gibt es verschiedene Förderinstitute, die für die Förderung von Sanierungsmaßnahmen zuständig sind. Dazu gehören zum Beispiel die KfW-Bankengruppe, die denkmalgeschützte Gebäude saniert, und das Bundesamt für Wirtschaft und Ausfuhrkontrolle (BAFA), das Fördermittel für den Einsatz erneuerbarer Energien bereitstellt. Die Förderinstitute können Ihnen genaue Informationen darüber geben, welche Förderungen für die Sanierung Ihres Gebäudes infrage kommen und wie Sie diese beantragen können.</p>
                ',
                'published' => true,
                'published_at' => Carbon::parse('2022-12-08'),
                'short_description' => 'Es kann sein, dass Sie für die Sanierung eines worst performing Buildings mehr Förderung bekommen, da solche Gebäude in der Regel ein größeres Einsparpotential haben und damit eine höhere Förderung gerechtfertigt ist. Allerdings hängt die Höhe der Förderung, die Sie für eine Sanierung bekommen, von verschiedenen Faktoren ab, wie zum Beispiel dem Bundesland, in dem das Gebäude liegt, den Sanierungsmaßnahmen, die durchgeführt werden, und Ihrem persönlichen Einkommen.',
            ],
            [
                'title' => 'Modernisierungsmaßnahmen im Energieausweis',
                'slug' => 'modernisierungsmaßnahmen-im-energieausweis',
                'user_id' => 2,
                'content' => '
                <p>Ein Energieausweis enthält Informationen über die Energieeffizienz eines Gebäudes und kann auch Vorschläge für Modernisierungsmaßnahmen enthalten, die dazu beitragen, den Energieverbrauch des Gebäudes zu reduzieren oder die Energieeffizienz zu verbessern.</p>
  <ul>
    <li>der Austausch von alten Fenstern gegen neue, energieeffiziente Fenster</li>
    <li>die Installation von Dämmung an Wänden, Dächern oder im Keller</li>
    <li>die Erneuerung der Heizungsanlage</li>
    <li>der Einbau von Solarkollektoren oder einer Photovoltaikanlage</li>
    <li>der Anbau von Wintergärten oder Solarien</li>
    <li>der Austausch von Glühlampen gegen energiesparende Leuchtmittel</li>
  </ul>
  <p>Die Vorschläge im Energieausweis sind dazu gedacht, den Energiebedarf des Gebäudes zu reduzieren und damit den CO2-Ausstoß zu senken. Sie können auch dazu beitragen, die Betriebskosten des Gebäudes zu reduzieren, indem der Energieverbrauch gesenkt wird.</p>
  <p>Die Vorschläge im Energieausweis sind keine verbindlichen Vorgaben, sondern dienen lediglich als Orientierung. Es obliegt dem Eigentümer oder Mieter des Gebäudes, zu entscheiden, welche Maßnahmen umgesetzt werden. Es empfiehlt sich jedoch, die Vorschläge im Energieausweis zu berücksichtigen, um die Energieeffizienz des Gebäudes zu verbessern und damit langfristig Kosten zu sparen.</p>
  <p>In der Regel muss der Energieausweis in Papierform vorgelegt werden. Der Energieausweis ist ein wichtiges Dokument, das Auskunft über die Energieeffizienz eines Gebäudes gibt und ist daher in der Regel in Papierform erforderlich.</p>
  <p>Es gibt jedoch auch die Möglichkeit, den Energieausweis in digitaler Form zu übermitteln. Dies ist z.B. möglich, wenn der Energieausweis über das Energieausweis-Portal der Bundesregierung abgerufen wird. In diesem Fall muss der Energieausweis jedoch noch immer in Papierform vorliegen und kann bei Bedarf ausgedruckt werden.</p>
  <p>Es empfiehlt sich daher, den Energieausweis in Papierform aufzubewahren, um ihn bei Bedarf vorlegen zu können. Wenn der Energieausweis in digitaler Form vorgelegt wird, sollten Sie darauf achten, dass er von einer vertrauenswürdigen Quelle stammt und dass er die notwendigen Angaben enthält, um die Energieeffizienz des Gebäudes einschätzen zu können.</p>
                ',
                'published' => true,
                'published_at' => Carbon::parse('2022-12-12'),
                'short_description' => 'Ein Energieausweis enthält Informationen über die Energieeffizienz eines Gebäudes und kann auch Vorschläge für Modernisierungsmaßnahmen enthalten, die dazu beitragen, den Energieverbrauch des Gebäudes zu reduzieren oder die Energieeffizienz zu verbessern.',
            ],
            [
                'title' => 'Achtung Vermieter: Was Sie über den Energieausweis wissen müssen',
                'slug' => 'achtung-vermieter-was-sie-ueber-den-energieausweis-wissen-muessen',
                'user_id' => 2,
                'content' => '
                <p>Als Vermieter sind Sie gesetzlich verpflichtet, einen Energieausweis vorzulegen, wenn Sie ein Gebäude vermieten. Der Energieausweis enthält Informationen über den Energiebedarf und den CO2-Ausstoß des Gebäudes und dient dazu, Interessenten eine Orientierung über die Energieeffizienz des Gebäudes zu geben.</p>
                <p>Wenn Sie als Vermieter keinen Energieausweis vorlegen, können Sie von den zuständigen Behörden verwarnungs- oder zu Geldbußen verurteilt werden. Die Höhe der Bußgelder kann je nach Bundesland unterschiedlich sein und kann sich auf mehrere Hundert Euro belaufen.</p>
                <p>Es empfiehlt sich daher, rechtzeitig vor der Vermietung einen Energieausweis zu beschaffen und diesen Interessenten zur Verfügung zu stellen. Der Energieausweis ist in der Regel 10 Jahre gültig und muss bei Änderungen an den Eigenschaften des Gebäudes, die die Energieeffizienz beeinflussen könnten, aktualisiert werden.</p>
                <p>Wenn die Verbrauchsdaten im Energieausweis falsch angegeben werden, kann dies zu Fehleinschätzungen der Energieeffizienz des Gebäudes führen. Die Verbrauchsdaten im Energieausweis dienen dazu, den Energieverbrauch des Gebäudes zu beschreiben und damit eine Orientierung über die Energieeffizienz des Gebäudes zu geben. Sie werden von einem Energieberater erhoben, der das Gebäude untersucht und die Angaben in einem von der Bundesregierung festgelegten Formular festhält.</p>
                <p>Wenn die Verbrauchsdaten im Energieausweis falsch angegeben werden, kann dies zu Fehlentscheidungen bei der Vermietung oder dem Verkauf des Gebäudes führen. Interessenten könnten das Gebäude für energieeffizienter halten, als es tatsächlich ist, und sich daher für die Anmietung oder den Kauf des Gebäudes entscheiden, ohne die tatsächlichen Betriebskosten zu berücksichtigen.</p>
                <p>Es ist daher wichtig, dass die Verbrauchsdaten im Energieausweis korrekt angegeben werden, um eine realistische Einschätzung</p>
                <p>Die Absichtliche Fälschung von Verbrauchsdaten im Energieausweis ist eine Straftat und kann mit Geld- oder Freiheitsstrafe geahndet werden. Die Fälschung von Verbrauchsdaten ist eine Form des Betrugs und kann nach dem Strafgesetzbuch (StGB) unter Strafe gestellt werden.</p>
                <p>Je nach Schwere der Tat und dem Schaden, der durch die Fälschung entstanden ist, kann die Strafe für die Absichtliche Fälschung von Verbrauchsdaten im Energieausweis von einer Geldstrafe bis hin zu einer Freiheitsstrafe von bis zu fünf Jahren reichen.</p>
                <p>Es ist daher wichtig, dass die Verbrauchsdaten im Energieausweis korrekt angegeben werden, um eine realistische Einschätzung der Energieeffizienz des Gebäudes zu ermöglichen und um rechtliche Konsequenzen zu vermeiden. Die Verbrauchsdaten im Energieausweis werden von einem Energieberater erhoben, der das Gebäude untersucht und die Angaben in einem von der Bundesregierung festgelegten Formular festhält. Es ist wichtig, dass der Energieberater die Verbrauchsdaten korrekt erhebt und festhält, um einen zuverlässigen Energieausweis zu erstellen.</p>
                ',
                'published' => true,
                'published_at' => Carbon::parse('2022-12-14'),
                'short_description' => 'Als Vermieter sind Sie gesetzlich verpflichtet, einen Energieausweis vorzulegen, wenn Sie ein Gebäude vermieten. Der Energieausweis enthält Informationen über den Energiebedarf und den CO2-Ausstoß des Gebäudes und dient dazu, Interessenten eine Orientierung über die Energieeffizienz des Gebäudes zu geben.',
            ],
            [
                'title' => 'Achtung Mieter: Was Sie über den Energieausweis wissen müssen',
                'slug' => 'achtung-mieter-was-sie-ueber-den-energieausweis-wissen-muessen',
                'user_id' => 2,
                'content' => '
                    <p>Wenn Sie ein Gebäude mieten möchten, sollten Sie beim Energieausweis auf folgende Punkte achten:</p>
                    <ol>
                    <li>Gültigkeit: Stellen Sie sicher, dass der Energieausweis noch gültig ist. Der Energieausweis ist in der Regel 10 Jahre gültig, muss aber bei Änderungen an den Eigenschaften des Gebäudes, die die Energieeffizienz beeinflussen könnten, aktualisiert werden.</li>
                    <li>Art des Energieausweises: Es gibt zwei Arten von Energieausweisen: den Bedarfsausweis und den Verbrauchsausweis. Der Bedarfsausweis gibt den voraussichtlichen Energiebedarf eines Gebäudes an, während der Verbrauchsausweis den tatsächlichen Energieverbrauch des Gebäudes anzeigt. Es empfiehlt sich, den Verbrauchsausweis zu wählen, da er eine realistischere Einschätzung des Energieverbrauchs des Gebäudes liefert.</li>
                    <li>Energiebedarf und CO2-Ausstoß: Prüfen Sie den Energiebedarf und den CO2-Ausstoß des Gebäudes im Energieausweis. Diese Angaben geben Auskunft über die Energieeffizienz des Gebäudes und können Ihnen helfen, die Betriebskosten des Gebäudes einzuschätzen.</li>
                    <li>Modernisierungsvorschläge: Der Energieausweis kann auch Vorschläge für Modernisierungsmaßnahmen enthalten, die dazu beitragen, den Energieverbrauch des Gebäudes zu reduzieren oder die Energieeffizienz zu verbessern. Berücksichtigen Sie diese Vorschläge, wenn Sie sich für ein Gebäude entscheiden.</li>
                    <li>5.	Energieberater: Prüfen Sie, ob der Energieausweis von einem zertifizierten Energieberater ausgestellt wurde. Ein zertifizierter Energieberater hat die notwendige Qualifikation, um den Energieausweis korrekt auszustellen und die Verbrauchsdaten korrekt zu erheben.</li>
                    </ol>
                    <p>Es empfiehlt sich, den Energieausweis sorgfältig zu prüfen, bevor Sie ein Gebäude mieten, um eine realistische Einschätzung zu machen.</p>
                ',
                'published' => true,
                'published_at' => Carbon::parse('2022-12-16'),
                'short_description' => 'Wenn Sie ein Gebäude mieten möchten, sollten Sie beim Energieausweis auf folgende Punkte achten: Gültigkeit, Art des Energieausweises, Energiebedarf und CO2-Ausstoß, Modernisierungsvorschläge, Energieberater.',
            ],
            [
                'title' => 'Energieausweis richtig lesen: Einzelmaßnahmen',
                'slug' => 'energieausweis-richtig-lesen-einzelmassnahmen',
                'user_id' => 2,
                'content' => '
                <p>Einzelmaßnahmen sind Maßnahmen, die einzeln oder unabhängig voneinander durchgeführt werden, um den Energieverbrauch eines Gebäudes zu reduzieren oder die Energieeffizienz zu verbessern. Einzelmaßnahmen können sowohl kleine als auch größere Veränderungen an einem Gebäude beinhalten und umfassen beispielsweise:</p>
                <ul>
                <li>den Austausch von Glühlampen gegen energiesparende Leuchtmittel</li>
                <li>den Austausch von alten Fenstern gegen neue, energieeffiziente Fenster</li>
                <li>die Installation von Dämmung an Wänden, Dächern oder im Keller</li>
                <li>die Erneuerung der Heizungsanlage</li>
                <li>die Erweiterung der Photovoltaikanlage</li>
                <li>den Anbau von Wintergärten oder Solarien</li>
                <p>Einzelmaßnahmen können sowohl von Eigentümern als auch von Mietern durchgeführt werden. In vielen Fällen gibt es finanzielle Unterstützung von der Regierung oder von Energieversorgungsunternehmen, um die Kosten für Einzelmaßnahmen zu senken.</p>
</ul>
                ',
                'published' => true,
                'published_at' => Carbon::parse('2022-12-18'),
                'short_description' => 'Einzelmaßnahmen sind Maßnahmen, die einzeln oder unabhängig voneinander durchgeführt werden, um den Energieverbrauch eines Gebäudes zu reduzieren oder die Energieeffizienz zu verbessern.',
            ],
            [
                'title' => 'Brauche ich einen Energieausweis für eine Einzelmaßnahme?',
                'slug' => 'brauche-ich-einen-energieausweis-fuer-eine-einzelmassnahme',
                'user_id' => 2,
                'content' => '
                <p>In der Regel ist für Einzelmaßnahmen, die zur Verbesserung der Energieeffizienz eines Gebäudes durchgeführt werden, kein Energieausweis erforderlich. Ein Energieausweis ist in der Regel erst dann erforderlich, wenn ein Gebäude verkauft oder vermietet wird oder wenn es zu einer wesentlichen Änderung der Nutzung des Gebäudes kommt.</p>
                <p>Es gibt jedoch Ausnahmen von dieser Regel, z.B. wenn eine Einzelmaßnahme durchgeführt wird, die in einem sogenannten "Sanierungsgebiet" liegt oder wenn die Einzelmaßnahme gefördert werden soll. In solchen Fällen kann es erforderlich sein, dass ein Energieausweis vorgelegt wird, um die Energieeffizienz des Gebäudes zu dokumentieren und um die Förderung zu beantragen.</p>
                <p>Es empfiehlt sich daher, sich bei der Durchführung von Einzelmaßnahmen an einen Energieberater oder das zuständige Baurechtsamt zu wenden, um sicherzustellen, dass alle erforderlichen Unterlagen und Nachweise vorliegen.</p>
                ',
                'published' => true,
                'published_at' => Carbon::parse('2022-12-20'),
                'short_description' => 'In der Regel ist für Einzelmaßnahmen, die zur Verbesserung der Energieeffizienz eines Gebäudes durchgeführt werden, kein Energieausweis erforderlich. Ein Energieausweis ist in der Regel erst dann erforderlich, wenn ein Gebäude verkauft oder vermietet wird oder wenn es zu einer wesentlichen Änderung der Nutzung des Gebäudes kommt.',
            ],
            [
                'title' => 'Wie werden Einzelmaßnahmen beantragt?',
                'slug' => 'wie-werden-einzelmassnahmen-beantragt',
                'user_id' => 2,
                'content' => '
                    <p>Der Antrag auf finanzielle Unterstützung für Einzelmaßnahmen wird in der Regel bei der zuständigen Energieagentur oder bei einem Energieversorgungsunternehmen gestellt. In der Regel muss dazu ein Formular ausgefüllt werden, in dem die geplanten Maßnahmen beschrieben werden. Es kann auch erforderlich sein, einen Nachweis über die geplanten Maßnahmen, z.B. in Form von Angeboten von Handwerkern oder Lieferanten, beizufügen.</p>
                    <p>Um einen Antrag auf finanzielle Unterstützung für Einzelmaßnahmen zu stellen, sollten Sie sich zunächst informieren, welche Förderprogramme es gibt und ob Sie dafür in Frage kommen. Es gibt zum Beispiel Förderprogramme für den Austausch von Heizungsanlagen, für den Einbau von Dämmung oder für den Anbau von Solarien. Die Bedingungen für die Förderung können je nach Programm unterschiedlich sein, z.B. gibt es Obergrenzen für die Förderhöhe oder Mindestanforderungen an die Energieeffizienz.</p>
                    <p>Um den Antrag auf finanzielle Unterstützung für Einzelmaßnahmen zu stellen, müssen Sie in der Regel folgende Schritte beachten:</p>
                    <ol>
                    <li>Informieren Sie sich über die verfügbaren Förderprogramme und prüfen Sie, ob Sie dafür in Frage kommen.</li>
                    <li>Sammeln Sie alle notwendigen Unterlagen, wie Angebote von Handwerkern oder Lieferanten und eventuell benötigte Nachweise</li>
                    <li>Laden Sie das Antragsformular von der Website der Energieagentur oder des Energieversorgungsunternehmens herunter oder fordern Sie es per Post an.</li>
                    <li>Füllen Sie das Antragsformular vollständig aus und legen Sie alle notwendigen Unterlagen bei.</li>
                    <li>Reichen Sie den Antrag bei der Energieagentur oder dem Energieversorgungsunternehmen ein.</li>
</ol>
<p>Es ist wichtig, dass der Antrag rechtzeitig gestellt wird, da es in der Regel Fristen für die Antragsstellung gibt. Es empfiehlt sich daher, frühzeitig mit der Planung von Einzelmaßnahmen zu beginnen und rechtzeitig den Antrag zu stellen.</p>
                ',
                'published' => true,
                'published_at' => Carbon::parse('2022-12-22'),
                'short_description' => 'Der Antrag auf finanzielle Unterstützung für Einzelmaßnahmen wird in der Regel bei der zuständigen Energieagentur oder bei einem Energieversorgungsunternehmen gestellt. In der Regel muss dazu ein Formular ausgefüllt werden, in dem die geplanten Maßnahmen beschrieben werden. Es kann auch erforderlich sein, einen Nachweis über die geplanten Maßnahmen, z.B. in Form von Angeboten von Handwerkern oder Lieferanten, beizufügen.',
            ],
            [
                'title' => 'Wie lange dauert es, bis ich die Förderung für eine Einzelmaßnahme bekomme?',
                'slug' => 'wie-lange-dauert-es-bis-ich-die-foerderung-fuer-eine-einzelmassnahme-bekomme',
                'user_id' => 2,
                'content' => '
                    <p>Die Dauer der Förderung für eine Einzelmaßnahme hängt davon ab, ob die Maßnahme gefördert wird und wie hoch die Förderung ist. In der Regel dauert es einige Wochen, bis die Förderung ausgezahlt wird. Es kann jedoch auch länger dauern, wenn die Antragsstellung kompliziert ist oder wenn die Förderung nicht sofort ausgezahlt werden kann.</p>
                    <p>Es ist wichtig, dass Sie rechtzeitig mit der Planung von Einzelmaßnahmen beginnen und rechtzeitig den Antrag auf finanzielle Unterstützung stellen, damit Sie die Förderung rechtzeitig erhalten.</p>
                ',
                'published' => true,
                'published_at' => Carbon::parse('2022-12-24'),
                'short_description' => 'Die Dauer der Förderung für eine Einzelmaßnahme hängt davon ab, ob die Maßnahme gefördert wird und wie hoch die Förderung ist. In der Regel dauert es einige Wochen, bis die Förderung ausgezahlt wird. Es kann jedoch auch länger dauern, wenn die Antragsstellung kompliziert ist oder wenn die Förderung nicht sofort ausgezahlt werden kann.',
            ],
            [
                'title' => 'Was passiert, wenn ich die Förderung für eine Einzelmaßnahme nicht bekomme?',
                'slug' => 'was-passiert-wenn-ich-die-foerderung-fuer-eine-einzelmassnahme-nicht-bekomme',
                'user_id' => 2,
                'content' => '
                    <p>Wenn Sie die Förderung für eine Einzelmaßnahme nicht bekommen, können Sie die Maßnahme trotzdem durchführen. Es gibt jedoch einige Ausnahmen, in denen es sinnvoll sein kann, die Maßnahme nicht durchzuführen, wenn Sie die Förderung nicht bekommen. Zum Beispiel kann es sinnvoll sein, die Maßnahme nicht durchzuführen, wenn die Maßnahme nur dann gefördert wird, wenn sie mit anderen Maßnahmen kombiniert wird. In diesem Fall kann es sinnvoll sein, die Maßnahme nicht durchzuführen, wenn Sie die Förderung nicht bekommen, da die Maßnahme dann nicht mehr gefördert wird.</p>
                    <p>Es ist wichtig, dass Sie rechtzeitig mit der Planung von Einzelmaßnahmen beginnen und rechtzeitig den Antrag auf finanzielle Unterstützung stellen, damit Sie die Förderung rechtzeitig erhalten.</p>
                ',
                'published' => true,
                'published_at' => Carbon::parse('2022-12-26'),
                'short_description' => 'Wenn Sie die Förderung für eine Einzelmaßnahme nicht bekommen, können Sie die Maßnahme trotzdem durchführen. Es gibt jedoch einige Ausnahmen, in denen es sinnvoll sein kann, die Maßnahme nicht durchzuführen, wenn Sie die Förderung nicht bekommen. Zum Beispiel kann es sinnvoll sein, die Maßnahme nicht durchzuführen, wenn die Maßnahme nur dann gefördert wird, wenn sie mit anderen Maßnahmen kombiniert wird. In diesem Fall kann es sinnvoll sein, die Maßnahme nicht durchzuführen, wenn Sie die Förderung nicht bekommen, da die Maßnahme dann nicht mehr gefördert wird.',
            ],
        ];

        foreach ($entries as $entry) {
            BlogEntry::create($entry);
        }
    }
}
