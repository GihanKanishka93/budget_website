<template>
  <div class="col-6">
    <h5 class="card-title text-start">Services/Products</h5>
    <div class="form-text mb-2">
      Describe this service in less than 50 words in a way customers will be
      attracted to this service
    </div>
    <form class="text-start">
      <div v-for="(item, index) in services" :key="index" class="card mb-4">
        <div class="card-body">
          <div class="form-floating mb-3">
            <input
              v-model="item.name"
              type="text"
              class="form-control form-control-sm"
              placeholder="Service/Product"
              :class="`service_` + index"
              required
            />
            <label>Service {{ index + 1 }}/Product {{ index + 1 }}</label>
          </div>
          <div class="form-floating">
            <textarea
              v-model="item.description"
              class="form-control"
              :class="`service_des_` + index"
              placeholder=""
              :id="`serviceTextarea` + index"
              style="height: 100px"
            ></textarea>
            <label :for="`serviceTextarea` + index">Description</label>
          </div>
        </div>
      </div>
    </form>
  </div>
</template>

<script>
export default {
  data: () => ({
    count: 5,
    serviceObj: {
      name: "",
      description: "",
    },
    validateField: false,
  }),
  props: ["services", "serviceValidate"],
  mounted() {
    for (let index = 0; index < this.count; index++) {
      this.services.push({ ...this.serviceObj });
    }
    this.applyServiceValidateWatcher();
  },
  methods: {
    validate() {
      if (this.services[0]?.name != "" && this.services[0]?.description != "") {
        this.validateField = true;
      } else {
        this.validateField = false;
      }
      this.$emit("update:serviceValidate", this.validateField);
    },
    applyServiceValidateWatcher() {
      this.$watch("services", {
        handler: function () {
          this.validate();
        },
        deep: true,
      });
    },
  },
};
</script>
