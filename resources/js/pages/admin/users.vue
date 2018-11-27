<template>
  <h1>Пользователи</h1>
</template>

<script>
  export default {
    layout: 'admin',

    middleware: ['auth', 'verified'],

    computed: {

    }
  }
</script>