/**
 * DIGITALIZAÇÃO PROFISSIONAL - MÓDULO DE ACESSIBILIDADE
 * Recursos focados em pessoas idosas e iniciantes:
 * - Aumento/Diminuição de fonte dinâmica
 * - Narração em voz alta (Web Speech API pt-BR)
 * - Geração de céu noturno estrelado
 */

document.addEventListener('DOMContentLoaded', () => {
  iniciarControleDeFonte();
  iniciarNarradorDeVoz();
  gerarCeuEstrelado();
});

// 1. Controle de Tamanho de Fonte
function iniciarControleDeFonte() {
  const btnDiminuir = document.getElementById('btn-fonte-diminuir');
  const btnNormal = document.getElementById('btn-fonte-normal');
  const btnAumentar = document.getElementById('btn-fonte-aumentar');

  const tamanhoSalvo = localStorage.getItem('digitaliza_fonte') || 'normal';
  aplicarTamanhoFonte(tamanhoSalvo);

  if (btnDiminuir) {
    btnDiminuir.addEventListener('click', () => {
      aplicarTamanhoFonte('normal');
      localStorage.setItem('digitaliza_fonte', 'normal');
    });
  }

  if (btnNormal) {
    btnNormal.addEventListener('click', () => {
      aplicarTamanhoFonte('lg');
      localStorage.setItem('digitaliza_fonte', 'lg');
    });
  }

  if (btnAumentar) {
    btnAumentar.addEventListener('click', () => {
      aplicarTamanhoFonte('xl');
      localStorage.setItem('digitaliza_fonte', 'xl');
    });
  }
}

function aplicarTamanhoFonte(tamanho) {
  document.body.classList.remove('font-lg', 'font-xl');
  if (tamanho === 'lg') {
    document.body.classList.add('font-lg');
  } else if (tamanho === 'xl') {
    document.body.classList.add('font-xl');
  }
}

// 2. Leitor de Instruções em Voz Alta (Web Speech API pt-BR)
let vozSelecionada = null;

function iniciarNarradorDeVoz() {
  if (!('speechSynthesis' in window)) {
    console.log('Navegador sem suporte a síntese de voz.');
    return;
  }

  function carregarVozes() {
    const vozes = window.speechSynthesis.getVoices();
    vozSelecionada = vozes.find(v => v.lang.startsWith('pt')) || vozes[0];
  }

  carregarVozes();
  if (speechSynthesis.onvoiceschanged !== undefined) {
    speechSynthesis.onvoiceschanged = carregarVozes;
  }

  // Anexa evento a todos os botões de narrar da página
  const botoesVoz = document.querySelectorAll('.btn-narrar-instrucao');
  botoesVoz.forEach(btn => {
    btn.addEventListener('click', () => {
      const textoAlvoId = btn.getAttribute('data-falar-alvo');
      const elementoTexto = textoAlvoId ? document.getElementById(textoAlvoId) : null;
      const textoParaFalar = elementoTexto ? elementoTexto.innerText : btn.getAttribute('data-falar-texto');

      if (textoParaFalar) {
        falarTexto(textoParaFalar);
      }
    });
  });
}

function falarTexto(texto) {
  if (!('speechSynthesis' in window)) return;

  // Interrompe falas anteriores
  window.speechSynthesis.cancel();

  const utterance = new SpeechSynthesisUtterance(texto);
  utterance.lang = 'pt-BR';
  utterance.rate = 0.9; // Velocidade confortável para pessoas idosas
  utterance.pitch = 1.0;
  if (vozSelecionada) {
    utterance.voice = vozSelecionada;
  }

  window.speechSynthesis.speak(utterance);
}

// 3. Gerador do Céu Noturno Estrelado
function gerarCeuEstrelado() {
  const containers = document.querySelectorAll('.stars-container');
  containers.forEach(container => {
    // Se já tiver estrelas geradas, não duplica
    if (container.children.length > 0) return;

    const quantidade = 60;
    for (let i = 0; i < quantidade; i++) {
      const star = document.createElement('div');
      star.className = 'star';
      
      const tamanho = Math.random() * 2.5 + 1.2;
      const top = Math.random() * 100;
      const left = Math.random() * 100;
      const duration = Math.random() * 3 + 2;
      const delay = Math.random() * 4;

      star.style.width = `${tamanho}px`;
      star.style.height = `${tamanho}px`;
      star.style.top = `${top}%`;
      star.style.left = `${left}%`;
      star.style.setProperty('--duration', `${duration}s`);
      star.style.setProperty('--delay', `${delay}s`);

      container.appendChild(star);
    }
  });
}
