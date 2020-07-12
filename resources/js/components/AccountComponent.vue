<template>
  <div class="container">
    <div v-if="account">
      <p>Conta: {{ account.number }}</p>
      <p>Saldo: {{ account.balance }}</p>
    </div>

    <form action="#" @submit.prevent="sendTransaction">
      <div class="form-group row">
        <div class="col-xs-3">
          <label for="description">Operação:</label>
          <select class="form-control" v-model="formData.description" name="description" id="description">
            <option value="deposit">Depósito</option>
            <option value="withdraw">Saque</option>
          </select>
        </div>
      </div>
      <div class="form-group row">
        <div class="col-xs-3">
          <input
            type="number"
            min="0.01"
            step="any"
            name="amount"
            class="form-control"
            v-model="formData.amount"
            placeholder="Quantia"
          />
        </div>
      </div>
      <div class="form-group">
        <button type="submit" class="btn btn-primary">Enviar</button>
      </div>
    </form>
  </div>
</template>

<script>
export default {
  created() {
    this.getAccount()
  },
  data() {
    return {
      account: {
        number: "",
        balance: ""
      },
      formData: {
        number: "",
        amount: "",
        description: ""
      },
    };
  },

  methods: {
    getAccount() {
      axios.get("/accounts").then(response => {
        this.account = response.data;
        this.account.balance = parseFloat(this.account.balance) / 100
        this.formData.number = response.data.number
      });
    },

    sendTransaction() {
      axios.post("/transactions", this.formData).then(response => {
        this.getAccount();
      });
    },
  }
};
</script>
