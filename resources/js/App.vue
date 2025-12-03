<template>
  <div id="app">
    <nav class="navbar">
      <div class="container">
        <h1 class="logo">🌱 Plant Management</h1>
      </div>
    </nav>

    <div class="container">
      <router-view />
    </div>

    <Notification />
  </div>
</template>

<script setup>
import Notification from './components/Notification.vue'
</script>

<style>
* {
  margin: 0;
  padding: 0;
  box-sizing: border-box;
}

body {
  font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
  background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
  min-height: 100vh;
}

#app {
  min-height: 100vh;
}

.navbar {
  background: white;
  box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
  padding: 1rem 0;
}

.logo {
  color: #667eea;
  font-size: 1.5rem;
}

.container {
  max-width: 1200px;
  margin: 0 auto;
  padding: 2rem;
}

.btn {
  padding: 0.75rem 1.5rem;
  border: none;
  border-radius: 8px;
  font-size: 1rem;
  cursor: pointer;
  transition: all 0.3s;
  font-weight: 600;
}

.btn-primary {
  background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
  color: white;
}

.btn-primary:hover {
  transform: translateY(-2px);
  box-shadow: 0 4px 12px rgba(102, 126, 234, 0.4);
}

.btn-danger {
  background: #e74c3c;
  color: white;
}

.btn-secondary {
  background: #95a5a6;
  color: white;
}
</style>
