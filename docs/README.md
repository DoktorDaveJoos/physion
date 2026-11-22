# Zähler – minimalistische Counter-PWA

Ein Tipp = +1. Jeder Tipp wird mit Zeitstempel im `localStorage` des Geräts gespeichert.
Reines HTML/CSS/JS, kein Build-Schritt. Alle Dateien liegen in diesem `docs/`-Ordner.

| Datei | Zweck |
|---|---|
| `index.html` | Oberfläche, PWA- und `apple-mobile-web-app`-Meta-Tags |
| `style.css` | Design, Dark Mode (`prefers-color-scheme`), Animationen |
| `app.js` | Zähllogik, Verlauf, Rückgängig, CSV-Export, Reset |
| `sw.js` | Service Worker für Offline-Nutzung |
| `manifest.json` | Web-App-Manifest |
| `icons/` | App-Icons (SVG-Quelle + PNGs) |

## Veröffentlichen mit GitHub Pages

1. Repository auf GitHub öffnen → **Settings** → **Pages**.
2. Unter **Build and deployment** → **Source**: „Deploy from a branch“.
3. **Branch**: den Branch mit dem `docs/`-Ordner wählen (z. B. `main`), Ordner **`/docs`**, **Save**.
4. Nach 1–2 Minuten ist die App erreichbar unter `https://<benutzername>.github.io/<repo>/`.

## Updates

Nach Änderungen an den Dateien in `sw.js` die Konstante `CACHE` hochzählen (`zaehler-v2`, …).
Die installierte App lädt die neue Version dann beim übernächsten Öffnen.
