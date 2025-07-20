<template>
  <div class="bg-red-500 w-1/2 h-1/2 border border-blue-500 rounded-lg shadow-lg p-6 auth-container">
    <h1 class="auth-title">Log in to your account</h1>
    <p class="auth-description">Enter your email and password below to log in</p>

    <div v-if="status" class="auth-status">
      {{ status }}
    </div>

    <form @submit.prevent="submit" class="auth-form">
      <div class="form-group">
        <label for="email">Email address</label>
        <input
          id="email"
          type="email"
          v-model="form.email"
          required
          autofocus
          autocomplete="email"
          placeholder="email@example.com"
        />
        <div v-if="form.errors.email" class="input-error">
          {{ form.errors.email }}
        </div>
      </div>

      <div class="form-group">
        <label for="password" class="flex-label">
          <span>Password</span>
          <a v-if="canResetPassword" :href="route('password.request')" class="forgot-password">
            Forgot password?
          </a>
        </label>
        <input
          id="password"
          type="password"
          v-model="form.password"
          required
          autocomplete="current-password"
          placeholder="Password"
        />
        <div v-if="form.errors.password" class="input-error">
          {{ form.errors.password }}
        </div>
      </div>

      <div class="form-group remember-me">
        <label>
          <input type="checkbox" v-model="form.remember" />
          Remember me
        </label>
      </div>

      <button type="submit" class="submit-button" :disabled="form.processing">
        <span v-if="form.processing" class="spinner"></span>
        Log in
      </button>
    </form>
  </div>
</template>

<script setup lang="ts">
import { Head, useForm } from '@inertiajs/vue3';
import { route } from 'ziggy-js';

defineProps<{
  status?: string;
  canResetPassword: boolean;
}>();

const form = useForm({
  email: '',
  password: '',
  remember: false,
});

const submit = () => {
  form.post(route('login'), {
    onFinish: () => form.reset('password'),
  });
};
</script>

<style scoped>
.auth-container {
  max-width: 400px;
  margin: 100px auto;
  padding: 2rem;
  border: 1px solid #ddd;
  border-radius: 8px;
  background-color: #fff;
  font-family: sans-serif;
}

.auth-title {
  font-size: 24px;
  font-weight: bold;
  margin-bottom: 0.5rem;
  text-align: center;
}

.auth-description {
  text-align: center;
  font-size: 14px;
  margin-bottom: 1.5rem;
  color: #666;
}

.auth-status {
  background-color: #d1fae5;
  color: #065f46;
  padding: 0.5rem;
  margin-bottom: 1rem;
  text-align: center;
  border-radius: 4px;
}

.auth-form {
  display: flex;
  flex-direction: column;
  gap: 1rem;
}

.form-group {
  display: flex;
  flex-direction: column;
}

.form-group label {
  font-size: 14px;
  margin-bottom: 0.4rem;
}

.form-group input[type="email"],
.form-group input[type="password"] {
  padding: 0.5rem;
  border-radius: 4px;
  border: 1px solid #ccc;
}

.input-error {
  font-size: 12px;
  color: red;
  margin-top: 0.25rem;
}

.forgot-password {
  font-size: 12px;
  color: #007bff;
  text-decoration: none;
  margin-left: auto;
}

.forgot-password:hover {
  text-decoration: underline;
}

.flex-label {
  display: flex;
  justify-content: space-between;
  align-items: center;
}

.remember-me {
  display: flex;
  align-items: center;
  font-size: 14px;
}

.submit-button {
  background-color: #16a34a;
  color: white;
  border: none;
  padding: 0.6rem;
  font-weight: bold;
  border-radius: 4px;
  cursor: pointer;
}

.submit-button:disabled {
  opacity: 0.6;
  cursor: not-allowed;
}

.spinner {
  display: inline-block;
  width: 16px;
  height: 16px;
  border: 2px solid #fff;
  border-top: 2px solid transparent;
  border-radius: 50%;
  margin-right: 6px;
  animation: spin 1s linear infinite;
}

@keyframes spin {
  to {
    transform: rotate(360deg);
  }
}
</style>
