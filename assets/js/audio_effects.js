/**
 * DIGITALIZAÇÃO PROFISSIONAL - EFEITOS SONOROS SUAVES
 * Gerados via Web Audio API (100% nativo, sem necessidade de arquivos externos)
 */

class SomDigita {
  constructor() {
    this.audioCtx = null;
    this.habilitado = localStorage.getItem('digitaliza_som') !== 'false';
  }

  init() {
    if (!this.audioCtx && (window.AudioContext || window.webkitAudioContext)) {
      const AudioCtx = window.AudioContext || window.webkitAudioContext;
      this.audioCtx = new AudioCtx();
    }
  }

  toggleSom() {
    this.habilitado = !this.habilitado;
    localStorage.setItem('digitaliza_som', this.habilitado ? 'true' : 'false');
    return this.habilitado;
  }

  // Toque suave ao pressionar tecla correta
  tocarTecla() {
    if (!this.habilitado) return;
    this.init();
    if (!this.audioCtx) return;

    try {
      const osc = this.audioCtx.createOscillator();
      const gain = this.audioCtx.createGain();

      osc.type = 'sine';
      osc.frequency.setValueAtTime(440 + Math.random() * 60, this.audioCtx.currentTime);
      
      gain.gain.setValueAtTime(0.08, this.audioCtx.currentTime);
      gain.gain.exponentialRampToValueAtTime(0.001, this.audioCtx.currentTime + 0.08);

      osc.connect(gain);
      gain.connect(this.audioCtx.destination);

      osc.start();
      osc.stop(this.audioCtx.currentTime + 0.08);
    } catch (e) {}
  }

  // Acorde harmonioso ao completar uma palavra flutuante
  tocarPalavraSucesso() {
    if (!this.habilitado) return;
    this.init();
    if (!this.audioCtx) return;

    try {
      const notas = [523.25, 659.25, 783.99, 1046.50]; // C5, E5, G5, C6 (Arpeggio maior estelar)
      notas.forEach((freq, idx) => {
        const osc = this.audioCtx.createOscillator();
        const gain = this.audioCtx.createGain();

        osc.type = 'triangle';
        osc.frequency.setValueAtTime(freq, this.audioCtx.currentTime + (idx * 0.07));

        const tempoInicio = this.audioCtx.currentTime + (idx * 0.07);
        gain.gain.setValueAtTime(0.12, tempoInicio);
        gain.gain.exponentialRampToValueAtTime(0.001, tempoInicio + 0.35);

        osc.connect(gain);
        gain.connect(this.audioCtx.destination);

        osc.start(tempoInicio);
        osc.stop(tempoInicio + 0.35);
      });
    } catch (e) {}
  }

  // Toque sutil e carinhoso em caso de erro (não punitivo)
  tocarErro() {
    if (!this.habilitado) return;
    this.init();
    if (!this.audioCtx) return;

    try {
      const osc = this.audioCtx.createOscillator();
      const gain = this.audioCtx.createGain();

      osc.type = 'sine';
      osc.frequency.setValueAtTime(220, this.audioCtx.currentTime);
      
      gain.gain.setValueAtTime(0.06, this.audioCtx.currentTime);
      gain.gain.exponentialRampToValueAtTime(0.001, this.audioCtx.currentTime + 0.15);

      osc.connect(gain);
      gain.connect(this.audioCtx.destination);

      osc.start();
      osc.stop(this.audioCtx.currentTime + 0.15);
    } catch (e) {}
  }
}

window.somDigita = new SomDigita();
