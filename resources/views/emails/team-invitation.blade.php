<x-mail::message>
# Einladung zu {{ $invitation->team->name }},

Falls du noch keinen Account hast, kannst du hier einen anlegen:

<x-mail::button :url='route("register")'>
Account anlegen
</x-mail::button>

Falls du bereits einen Account hast, kannst du die Einladung hier annehmen:
<x-mail::button :url='$acceptUrl'>
Einladung annehmen
</x-mail::button>

Schön, dass du dabei bist!
Dein Bauzertifikate Team
</x-mail::message>
