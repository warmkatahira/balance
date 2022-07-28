(function(window, document) {
  const animTime = 5000; // アニメーション時間(ms)
  const speed = 100; // テキストの移動速度(px)
  const limit = 0; // ブレークポイント(px)
  let animId;
  let isRunning = false;

  const ticker = document.querySelector('.ticker');
  loadTicker();

  function loadTicker() {
    tickerAnim();
    animId = setInterval(tickerAnim, animTime);
    isRunning = true;
  }

  // アニメーション処理
  function tickerAnim() {
    const items = ticker.querySelectorAll('.ticker-item');
    const running = ticker.querySelector('.run');
    let idx, link, first, next;
    if (!running) { // 実行中の要素がない場合（初回のみ）
      first = items[0];
      link = first.querySelector('a');
      first.classList.add('fadeInDown', 'run');
      first.style.zIndex = 1;
      setTimeout(textMove, 1000, link); // 第3引数に引数linkを指定。こうしないと即実行されてしまうので注意。
    } else {
      for (let i = 0; i < items.length; i++) {
        if (items[i] == running) {
          idx = i; // 実行中要素のインデックスを取得
          break;
        }
      }
      next = items[(idx + 1) % items.length];
      running.classList.replace('fadeInDown', 'fadeOutDown');
      setTimeout(() => {
        running.classList.remove('fadeOutDown', 'run');
        running.style.zIndex = 0;
        link = running.querySelector('a');
        link.style.transform = 'none';
        next.classList.add('fadeInDown', 'run');
        next.style.zIndex = 1;
        link = next.querySelector('a');
        setTimeout(textMove, 1000, link);
      }, 300);
    }
  }

  // テキスト移動処理
  function textMove(elm) {
    const move = elm.parentNode.clientWidth - elm.clientWidth;
    if (move < 0) {
      elm.style.transform = 'translateX(' + move + 'px)';
      elm.style.transitionDuration = Math.abs(move) / speed + 's';
    }
  }

  // ウィンドウサイズ変更時
  window.addEventListener('resize', () => {
    const windowWidth = window.innerWidth;
    if (windowWidth <= limit) {
      ticker.style.display = 'none';
      clearInterval(animId);
      isRunning = false;
    } else {
      if (!isRunning) {
        ticker.style.display = 'block';
        animId = setInterval(tickerAnim, animTime);
        isRunning = true;
      }
    }
  });
})(window, document);