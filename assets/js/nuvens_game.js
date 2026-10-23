/**
 * DIGITALIZAÇÃO PROFISSIONAL
 * Jogo / Treinador Interativo: Palavras Flutuantes sobre as Nuvens da Noite com a Lua Amarela
 * Otimizado para idosos e iniciantes do zero.
 */

class NuvensGame {
  constructor(config = {}) {
    this.container = document.getElementById('sky-game-area');
    this.palavrasBase = config.palavras || ['lua', 'sol', 'paz', 'amor', 'ceu', 'vida', 'saude', 'amigo'];
    this.nivel = config.nivel || 'iniciante_zero';
    this.velocidade = config.velocidade || 'lento'; // lento, normal, rapido

    this.nuvensAtivas = [];
    this.nuvemAtualIndex = 0;
    this.caractereIndex = 0;

    this.palavrasCertas = 0;
    this.palavrasErradas = 0;
    this.totalTeclas = 0;
    this.teclasCertas = 0;
    this.pontos = 0;
    this.tempoInicio = null;
    this.timerLoop = null;
    this.pausado = false;

    this.init();
  }

  init() {
    this.configurarVelocidade();
    this.adicionarOuvintesTeclado();
    this.iniciarPartida();
  }

  configurarVelocidade() {
    const velocidades = {
      'lento': { tempoSpawn: 7000, duracaoAnimacao: 18 },
      'normal': { tempoSpawn: 5000, duracaoAnimacao: 14 },
      'rapido': { tempoSpawn: 3500, duracaoAnimacao: 9 }
    };
    this.configSpeed = velocidades[this.velocidade] || velocidades['lento'];
  }

  iniciarPartida() {
    this.pausado = false;
    this.tempoInicio = Date.now();
    this.atualizarPlacarUI();

    // Cria a primeira nuvem imediatamente para o aluno não ter que esperar
    this.criarNuvem();

    // Loop contínuo de geração de nuvens
    clearInterval(this.timerLoop);
    this.timerLoop = setInterval(() => {
      if (!this.pausado && this.nuvensAtivas.length < 4) {
        this.criarNuvem();
      }
    }, this.configSpeed.tempoSpawn);
  }

  criarNuvem() {
    if (!this.container) return;

    const palavra = this.palavrasBase[Math.floor(Math.random() * this.palavrasBase.length)];
    const nuvemId = 'nuvem_' + Date.now() + '_' + Math.floor(Math.random() * 1000);

    // Posição vertical segura no céu (entre 10% e 65% da altura da área)
    const topPercent = Math.floor(Math.random() * 45) + 15;

    const elNuvem = document.createElement('div');
    elNuvem.id = nuvemId;
    elNuvem.className = 'game-cloud night-cloud';
    elNuvem.style.top = `${topPercent}%`;
    elNuvem.style.left = '105%'; // Inicia fora da tela à direita

    // Renderização das letras estilizadas
    const letrasHtml = palavra.split('').map((letra, idx) => {
      return `<span class="game-letter ${idx === 0 ? 'letter-pending' : 'letter-pending'}" data-letra="${letra}">${letra}</span>`;
    }).join('');

    elNuvem.innerHTML = `
      <div class="relative z-10 flex items-center gap-1 font-bold text-2xl tracking-wider text-slate-800">
        ${letrasHtml}
      </div>
    `;

    this.container.appendChild(elNuvem);

    const objNuvem = {
      id: nuvemId,
      elemento: elNuvem,
      palavra: palavra,
      letras: palavra.split(''),
      progressoLetra: 0,
      posicaoX: 105,
      velocidadeX: this.obterVelocidadeDeslocamento()
    };

    this.nuvensAtivas.push(objNuvem);

    // Se for a primeira nuvem ativa, foca nela
    if (this.nuvensAtivas.length === 1) {
      this.atualizarNuvemAlvo();
    }

    // Inicia a animação de deslocamento suave
    this.animarNuvem(objNuvem);
  }

  obterVelocidadeDeslocamento() {
    switch (this.velocidade) {
      case 'lento': return 0.055;  // Bem calmo para idosos acompanharem sem afobação
      case 'normal': return 0.085;
      case 'rapido': return 0.13;
      default: return 0.06;
    }
  }

  animarNuvem(objNuvem) {
    const passo = () => {
      if (!this.nuvensAtivas.includes(objNuvem)) return;

      if (!this.pausado) {
        objNuvem.posicaoX -= objNuvem.velocidadeX;
        objNuvem.elemento.style.left = `${objNuvem.posicaoX}%`;

        // Se atravessou a tela inteira sem digitar
        if (objNuvem.posicaoX < -25) {
          this.removerNuvemPerdida(objNuvem);
          return;
        }
      }

      requestAnimationFrame(passo);
    };

    requestAnimationFrame(passo);
  }

  removerNuvemPerdida(objNuvem) {
    if (objNuvem.elemento && objNuvem.elemento.parentNode) {
      objNuvem.elemento.parentNode.removeChild(objNuvem.elemento);
    }
    const idx = this.nuvensAtivas.indexOf(objNuvem);
    if (idx > -1) {
      this.nuvensAtivas.splice(idx, 1);
      this.palavrasErradas++;
      this.atualizarPlacarUI();
      this.atualizarNuvemAlvo();
    }
  }

  atualizarNuvemAlvo() {
    // Remove destaque anterior
    document.querySelectorAll('.game-cloud').forEach(el => el.classList.remove('target-cloud'));

    if (this.nuvensAtivas.length > 0) {
      const nuvemAlvo = this.nuvensAtivas[0];
      nuvemAlvo.elemento.classList.add('target-cloud');
      
      const proximaLetra = nuvemAlvo.palavra[nuvemAlvo.progressoLetra];
      this.destacarTeclaVirtual(proximaLetra);
      this.atualizarLetrasNuvem(nuvemAlvo);
    } else {
      this.desmarcarTeclasVirtuais();
    }
  }

  atualizarLetrasNuvem(objNuvem) {
    const spans = objNuvem.elemento.querySelectorAll('.game-letter');
    spans.forEach((span, idx) => {
      span.className = 'game-letter';
      if (idx < objNuvem.progressoLetra) {
        span.classList.add('letter-correct');
      } else if (idx === objNuvem.progressoLetra) {
        span.classList.add('letter-current');
      } else {
        span.classList.add('letter-pending');
      }
    });
  }

  destacarTeclaVirtual(letra) {
    this.desmarcarTeclasVirtuais();
    if (!letra) return;

    const teclaLimpa = letra.toLowerCase();
    const teclaEl = document.querySelector(`.virtual-key[data-key="${teclaLimpa}"]`);
    if (teclaEl) {
      teclaEl.classList.add('key-active');
      
      // Atualiza dica de dedo amigável para o aluno idoso
      const dedoInfo = teclaEl.getAttribute('data-dedo') || 'Dedo indicador';
      const maoInfo = teclaEl.getAttribute('data-mao') || 'Direita';
      const dicaEl = document.getElementById('dica-dedo-aluno');
      if (dicaEl) {
        dicaEl.innerHTML = `Pressione a tecla <strong class="text-yellow-300 uppercase">${letra}</strong> com o <strong>${dedoInfo}</strong> da mão <strong>${maoInfo}</strong>.`;
      }
    }
  }

  desmarcarTeclasVirtuais() {
    document.querySelectorAll('.virtual-key').forEach(k => k.classList.remove('key-active'));
  }

  adicionarOuvintesTeclado() {
    window.addEventListener('keydown', (e) => {
      if (this.pausado || this.nuvensAtivas.length === 0) return;

      // Evita rolagem da barra de espaço
      if (e.key === ' ' || e.code === 'Space') {
        e.preventDefault();
      }

      const teclaPressionada = e.key.toLowerCase();
      
      // Ignora teclas de controle como Shift, Alt, Ctrl, etc.
      if (e.key.length > 1 && e.key !== 'Backspace' && e.key !== ' ') return;

      this.processarEntradaLetra(teclaPressionada);
    });

    // Permite também tocar ou clicar no teclado virtual na tela para quem usa tablet ou mouse!
    document.querySelectorAll('.virtual-key').forEach(teclaBtn => {
      teclaBtn.addEventListener('click', () => {
        const key = teclaBtn.getAttribute('data-key');
        if (key) {
          this.processarEntradaLetra(key);
        }
      });
    });
  }

  processarEntradaLetra(tecla) {
    if (this.nuvensAtivas.length === 0) return;

    this.totalTeclas++;
    const nuvemAlvo = this.nuvensAtivas[0];
    const letraEsperada = nuvemAlvo.palavra[nuvemAlvo.progressoLetra]?.toLowerCase();

    if (tecla === letraEsperada) {
      // Acerto!
      this.teclasCertas++;
      nuvemAlvo.progressoLetra++;
      
      if (window.somDigita) {
        window.somDigita.tocarTecla();
      }

      this.atualizarLetrasNuvem(nuvemAlvo);

      // Verificação de palavra concluída
      if (nuvemAlvo.progressoLetra >= nuvemAlvo.palavra.length) {
        this.concluirPalavraSucesso(nuvemAlvo);
      } else {
        const proximaLetra = nuvemAlvo.palavra[nuvemAlvo.progressoLetra];
        this.destacarTeclaVirtual(proximaLetra);
      }
    } else {
      // Tecla errada
      if (window.somDigita) {
        window.somDigita.tocarErro();
      }
      
      // Efeito de feedback suave na nuvem sem agredir
      nuvemAlvo.elemento.classList.add('animate-shake');
      setTimeout(() => nuvemAlvo.elemento.classList.remove('animate-shake'), 400);
    }

    this.atualizarPlacarUI();
  }

  concluirPalavraSucesso(nuvemAlvo) {
    this.palavrasCertas++;
    this.pontos += (nuvemAlvo.palavra.length * 15) + 50;

    if (window.somDigita) {
      window.somDigita.tocarPalavraSucesso();
    }

    // Animação de dissolução da nuvem voando rumo à lua amarela
    nuvemAlvo.elemento.classList.add('cloud-success');

    // Efeito de partículas estelares
    this.criarExplosaoEstrelas(nuvemAlvo.elemento);

    setTimeout(() => {
      if (nuvemAlvo.elemento && nuvemAlvo.elemento.parentNode) {
        nuvemAlvo.elemento.parentNode.removeChild(nuvemAlvo.elemento);
      }
    }, 600);

    const idx = this.nuvensAtivas.indexOf(nuvemAlvo);
    if (idx > -1) {
      this.nuvensAtivas.splice(idx, 1);
    }

    this.atualizarPlacarUI();
    this.atualizarNuvemAlvo();

    // Se acabou as nuvens, cria uma nova imediatamente
    if (this.nuvensAtivas.length === 0) {
      setTimeout(() => this.criarNuvem(), 400);
    }
  }

  criarExplosaoEstrelas(elemento) {
    const rect = elemento.getBoundingClientRect();
    const containerRect = this.container.getBoundingClientRect();

    for (let i = 0; i < 8; i++) {
      const p = document.createElement('div');
      p.className = 'absolute rounded-full pointer-events-none';
      p.style.width = '8px';
      p.style.height = '8px';
      p.style.backgroundColor = '#fde047';
      p.style.boxShadow = '0 0 10px #facc15';
      
      const startX = (rect.left - containerRect.left) + rect.width / 2;
      const startY = (rect.top - containerRect.top) + rect.height / 2;
      p.style.left = `${startX}px`;
      p.style.top = `${startY}px`;

      this.container.appendChild(p);

      const rad = (Math.PI * 2 / 8) * i;
      const dist = 50 + Math.random() * 30;
      const targetX = startX + Math.cos(rad) * dist;
      const targetY = startY + Math.sin(rad) * dist - 20;

      p.animate([
        { transform: 'scale(1)', opacity: 1 },
        { transform: `translate(${targetX - startX}px, ${targetY - startY}px) scale(0)`, opacity: 0 }
      ], {
        duration: 700,
        easing: 'ease-out'
      }).onfinish = () => p.remove();
    }
  }

  calcularEstatisticas() {
    const minutos = Math.max(0.1, (Date.now() - (this.tempoInicio || Date.now())) / 60000);
    const ppm = Math.round(this.palavrasCertas / minutos);
    const precisao = this.totalTeclas > 0 ? ((this.teclasCertas / this.totalTeclas) * 100).toFixed(1) : '100.0';

    return { ppm, precisao, pontos: this.pontos, certas: this.palavrasCertas, erradas: this.palavrasErradas };
  }

  atualizarPlacarUI() {
    const { ppm, precisao, pontos, certas } = this.calcularEstatisticas();

    const elPontos = document.getElementById('stat-pontos');
    const elCertas = document.getElementById('stat-certas');
    const elPrecisao = document.getElementById('stat-precisao');
    const elPpm = document.getElementById('stat-ppm');

    if (elPontos) elPontos.innerText = pontos;
    if (elCertas) elCertas.innerText = certas;
    if (elPrecisao) elPrecisao.innerText = `${precisao}%`;
    if (elPpm) elPpm.innerText = ppm;
  }

  async salvarProgressoServidor() {
    const stats = this.calcularEstatisticas();
    try {
      const resp = await fetch('backend/save_progress.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({
          modo: 'nuvens_flutuantes',
          palavras_certas: stats.certas,
          palavras_erradas: stats.erradas,
          precisao_pct: parseFloat(stats.precisao),
          ppm: stats.ppm,
          pontos: stats.pontos
        })
      });

      const json = await resp.json();
      if (json.sucesso && json.novas_conquistas && json.novas_conquistas.length > 0) {
        json.novas_conquistas.forEach(conq => {
          this.exibirAvisoConquista(conq);
        });
      }
      return json;
    } catch (e) {
      console.log('Erro ao salvar progresso:', e);
    }
  }

  exibirAvisoConquista(conq) {
    const toast = document.createElement('div');
    toast.className = 'fixed bottom-6 right-6 z-50 bg-yellow-500 text-slate-950 px-6 py-4 rounded-2xl shadow-2xl flex items-center gap-4 animate-bounce border-2 border-white';
    toast.innerHTML = `
      <span class="text-3xl">${conq.icone || '🏆'}</span>
      <div>
        <p class="font-extrabold text-sm uppercase tracking-wider text-slate-900">Nova Medalha Conquistada!</p>
        <p class="font-bold text-lg">${conq.titulo}</p>
        <p class="text-xs text-slate-800">${conq.descricao}</p>
      </div>
    `;
    document.body.appendChild(toast);
    setTimeout(() => toast.remove(), 6000);
  }

  destruir() {
    clearInterval(this.timerLoop);
    this.salvarProgressoServidor();
    this.nuvensAtivas.forEach(n => {
      if (n.elemento && n.elemento.parentNode) n.elemento.parentNode.removeChild(n.elemento);
    });
    this.nuvensAtivas = [];
  }
}

window.NuvensGame = NuvensGame;
