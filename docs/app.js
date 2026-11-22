'use strict';

const STORAGE_KEY = 'zaehler.taps.v1';
const DAYS = 14;

const $ = (id) => document.getElementById(id);
const el = {
  tap: $('tap'),
  todayCount: $('todayCount'),
  todayStat: $('todayStat'),
  totalStat: $('totalStat'),
  avgStat: $('avgStat'),
  chart: $('chart'),
  undoBtn: $('undoBtn'),
  settingsBtn: $('settingsBtn'),
  settings: $('settings'),
  dataInfo: $('dataInfo'),
  exportBtn: $('exportBtn'),
  resetArea: $('resetArea'),
  resetBtn: $('resetBtn'),
  resetConfirm: $('resetConfirm'),
  resetText: $('resetText'),
  resetCancel: $('resetCancel'),
  resetYes: $('resetYes'),
  toast: $('toast'),
  hapticLabel: $('hapticLabel'),
};

/* ---------- Daten ---------- */

let taps = load(); // aufsteigend sortierte Unix-Zeitstempel (ms)

function load() {
  try {
    const arr = JSON.parse(localStorage.getItem(STORAGE_KEY) || '[]');
    return Array.isArray(arr) ? arr.filter(Number.isFinite).sort((a, b) => a - b) : [];
  } catch {
    return [];
  }
}

function save() {
  try {
    localStorage.setItem(STORAGE_KEY, JSON.stringify(taps));
  } catch {
    toast('Speichern fehlgeschlagen');
  }
}

const pad = (n) => String(n).padStart(2, '0');
const dayKey = (d) => `${d.getFullYear()}-${pad(d.getMonth() + 1)}-${pad(d.getDate())}`;
const timeStr = (d) => `${pad(d.getHours())}:${pad(d.getMinutes())}:${pad(d.getSeconds())}`;
const fmt = new Intl.NumberFormat('de-DE', { maximumFractionDigits: 1 });
const weekday = new Intl.DateTimeFormat('de-DE', { weekday: 'short' });
const longDate = new Intl.DateTimeFormat('de-DE', { weekday: 'short', day: 'numeric', month: 'numeric' });

function countsByDay() {
  const map = new Map();
  for (const t of taps) {
    const k = dayKey(new Date(t));
    map.set(k, (map.get(k) || 0) + 1);
  }
  return map;
}

/* ---------- Darstellung ---------- */

let renderedDay = '';

function render() {
  const now = new Date();
  renderedDay = dayKey(now);
  const byDay = countsByDay();
  const today = byDay.get(renderedDay) || 0;

  // letzte 14 Tage (inkl. heute)
  const days = [];
  for (let i = DAYS - 1; i >= 0; i--) {
    const d = new Date(now.getFullYear(), now.getMonth(), now.getDate() - i);
    days.push({ date: d, count: byDay.get(dayKey(d)) || 0, isToday: i === 0 });
  }
  const sum14 = days.reduce((s, d) => s + d.count, 0);
  const max = Math.max(1, ...days.map((d) => d.count));

  el.todayCount.textContent = today;
  el.todayStat.textContent = today;
  el.totalStat.textContent = taps.length;
  el.avgStat.textContent = fmt.format(sum14 / DAYS);
  el.undoBtn.disabled = taps.length === 0;

  el.chart.replaceChildren(
    ...days.map(({ date, count, isToday }) => {
      const col = document.createElement('div');
      col.className = 'day' + (isToday ? ' today' : '') + (count === 0 ? ' zero' : '');
      col.title = `${longDate.format(date)}: ${count}`;
      col.setAttribute('role', 'img');
      col.setAttribute('aria-label', `${longDate.format(date)}: ${count}`);

      const value = document.createElement('span');
      value.textContent = count > 0 ? count : '';

      const track = document.createElement('div');
      track.className = 'day-track';
      const bar = document.createElement('div');
      bar.className = 'day-bar';
      bar.style.height = `${(count / max) * 100}%`;
      track.append(bar);

      const label = document.createElement('span');
      label.textContent = weekday.format(date).slice(0, 2);

      col.append(value, track, label);
      return col;
    })
  );
}

/* ---------- Feedback ---------- */

function haptic() {
  if (typeof navigator.vibrate === 'function') {
    navigator.vibrate(12);
  } else {
    // iOS Safari kennt keine Vibration-API; das Umschalten eines Switches löst dort (ab iOS 18) Haptik aus.
    try { el.hapticLabel.click(); } catch { /* egal */ }
  }
}

function bump() {
  el.todayCount.classList.remove('bump');
  void el.todayCount.offsetWidth; // Animation neu starten
  el.todayCount.classList.add('bump');
}

function ripple(x, y) {
  const r = el.tap.getBoundingClientRect();
  const dot = document.createElement('span');
  dot.className = 'ripple';
  dot.style.left = `${x - r.left}px`;
  dot.style.top = `${y - r.top}px`;
  el.tap.append(dot);
  dot.addEventListener('animationend', () => dot.remove(), { once: true });
  setTimeout(() => dot.remove(), 1000);
}

let toastTimer;
function toast(msg) {
  el.toast.textContent = msg;
  el.toast.classList.add('show');
  clearTimeout(toastTimer);
  toastTimer = setTimeout(() => el.toast.classList.remove('show'), 1800);
}

/* ---------- Aktionen ---------- */

function increment() {
  taps.push(Date.now());
  save();
  render();
  bump();
  haptic();
}

function undo() {
  if (!taps.length) return;
  const last = taps.pop();
  save();
  render();
  haptic();
  const d = new Date(last);
  const when = dayKey(d) === renderedDay ? `${pad(d.getHours())}:${pad(d.getMinutes())}` : longDate.format(d);
  toast(`Tipp von ${when} entfernt`);
}

async function exportCsv() {
  if (!taps.length) {
    toast('Noch keine Daten');
    return;
  }
  const lines = ['zeitstempel_utc,datum,uhrzeit,unix_ms'];
  for (const t of taps) {
    const d = new Date(t);
    lines.push([d.toISOString(), dayKey(d), timeStr(d), t].join(','));
  }
  const name = `zaehler-${dayKey(new Date())}.csv`;
  const file = new File([lines.join('\n') + '\n'], name, { type: 'text/csv' });

  // Auf dem iPhone ist das Teilen-Menü der zuverlässigste Weg (Dateien sichern, AirDrop, Mail …)
  if (navigator.canShare && navigator.canShare({ files: [file] })) {
    try {
      await navigator.share({ files: [file], title: name });
      return;
    } catch (e) {
      if (e.name === 'AbortError') return;
    }
  }
  const url = URL.createObjectURL(file);
  const a = document.createElement('a');
  a.href = url;
  a.download = name;
  document.body.append(a);
  a.click();
  a.remove();
  setTimeout(() => URL.revokeObjectURL(url), 2000);
}

function showResetConfirm(show) {
  el.resetArea.hidden = show;
  el.resetConfirm.hidden = !show;
  if (show) {
    el.resetText.textContent = `Wirklich alle ${taps.length} Einträge löschen? Das kann nicht rückgängig gemacht werden.`;
  }
}

function resetAll() {
  taps = [];
  save();
  render();
  showResetConfirm(false);
  el.settings.close();
  toast('Alle Daten gelöscht');
}

function openSettings() {
  showResetConfirm(false);
  el.dataInfo.textContent = taps.length
    ? `${taps.length} Einträge seit ${new Date(taps[0]).toLocaleDateString('de-DE')}.`
    : 'Noch keine Einträge.';
  el.resetBtn.disabled = taps.length === 0;
  if (typeof el.settings.showModal === 'function') el.settings.showModal();
  else el.settings.setAttribute('open', '');
}

/* ---------- Events ---------- */

// Sofortiges visuelles Feedback beim Berühren, gezählt wird beim Loslassen (click).
el.tap.addEventListener('pointerdown', (e) => {
  if (!e.isPrimary) return;
  el.tap.classList.add('pressed');
  ripple(e.clientX, e.clientY);
});
const release = () => el.tap.classList.remove('pressed');
el.tap.addEventListener('pointerup', release);
el.tap.addEventListener('pointercancel', release);
el.tap.addEventListener('pointerleave', release);
el.tap.addEventListener('click', increment);

el.undoBtn.addEventListener('click', undo);
el.settingsBtn.addEventListener('click', openSettings);
el.exportBtn.addEventListener('click', exportCsv);
el.resetBtn.addEventListener('click', () => showResetConfirm(true));
el.resetCancel.addEventListener('click', () => showResetConfirm(false));
el.resetYes.addEventListener('click', resetAll);
el.settings.addEventListener('click', (e) => {
  if (e.target === el.settings) el.settings.close(); // Tipp auf den Hintergrund schließt
});

// Pinch-Zoom in iOS unterbinden
document.addEventListener('gesturestart', (e) => e.preventDefault());

// Tageswechsel (Mitternacht) und Rückkehr in die App
document.addEventListener('visibilitychange', () => {
  if (document.visibilityState === 'visible') {
    taps = load();
    render();
  }
});
setInterval(() => {
  if (dayKey(new Date()) !== renderedDay) render();
}, 30_000);

// Andere Tabs/Fenster synchron halten
window.addEventListener('storage', (e) => {
  if (e.key === STORAGE_KEY) {
    taps = load();
    render();
  }
});

render();

/* ---------- Offline & Speicher ---------- */

if ('serviceWorker' in navigator) {
  window.addEventListener('load', () => {
    navigator.serviceWorker.register('sw.js').catch(() => {});
  });
}
if (navigator.storage && navigator.storage.persist) {
  navigator.storage.persist().catch(() => {});
}
