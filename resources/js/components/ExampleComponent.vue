<template>
  <div class="container">
    <!-- login form -->

    <div class="row mt-4" v-if="!accounts.length">
      <div class="col-6 offset-3">
        <form action="#" @submit.prevent="login">
          <h3>Capgemini</h3>
          <div class="form-row">
            <input
              type="email"
              name="email"
              class="form-control"
              v-model="formData.email"
              placeholder="Email"
            />
          </div>
          <div class="form-row">
            <input
              type="password"
              name="password"
              class="form-control"
              v-model="formData.password"
              placeholder="Senha"
            />
          </div>
          <div class="form-row">
            <button type="submit" class="btn btn-primary">Entrar</button>
          </div>
        </form>
      </div>
    </div>

    <!-- account details -->

    <div class="row mt-4" v-if="accounts.length">
      <div class="col-6 offset-3">
        <h3>Minha conta</h3>
        <div class="account" v-for="(account, index) in accounts" :key="index">
          Conta: <p v-text="account.number"></p>
          Saldo: <p v-text="account.balance"></p>
        </div>
      </div>
    </div>

  </div>
</template>

<script>
export default {
  data() {
    return {
      accounts: [],
      formData: {
        email: "",
        password: ""
      }
    };
  },

  methods: {
    login() {
      axios.get('/sanctum/csrf-cookie').then(response => {
        axios.post('/login', this.formData).then(response => {
          this.getAccount()
        })
      })
    },

    getAccount() {
      axios.get('/api/accounts').then(response => {
        this.accounts = response.data
      })
    }
  }
};
</script>

<style>
.form-row {
  margin-bottom: 8px;
}
</style>