<template>
  <div class="desktop-wrapper">
    <header class="desktop-header">
      <h1>Мобильное PWA-приложение клининговой компании</h1>
      <p>Ниже отображается мобильная версия внутри окна.</p>
    </header>

    <div class="desktop-iframe-container">
      <iframe
        src="/"
        class="pwa-iframe"
        frameborder="0"
      ></iframe>
    </div>
  </div>
</template>

<style scoped>
.desktop-wrapper {
  display: flex;
  flex-direction: column;
  height: 100vh;
}

.desktop-header {
  padding: 12px 16px;
  background: #f3f4f6;
  border-bottom: 1px solid #e5e7eb;
}

.desktop-iframe-container {
  flex: 1;
  overflow: hidden;
}

.pwa-iframe {
  width: 375px;      /* ширина под телефон */
  height: 100%;
  border: 1px solid #e5e7eb;
  margin: 0 auto;
  display: block;
}
</style>
