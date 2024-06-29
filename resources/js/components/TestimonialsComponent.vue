<template>
  <div id="testimonial-box" class="text-start">
    <div v-for="(item, index) in testimonials" :key="index" class="card mb-2">
      <div class="card-body">
        <div class="mb-3 row">
          <label class="col-3 col-form-label">Customer</label>
          <div class="col-6">
            <input
              v-model="item.customer"
              type="text"
              class="form-control form-control-sm"
            />
          </div>
        </div>
        <div class="mb-3 row">
          <label class="col-3 col-form-label">Company</label>
          <div class="col-6">
            <input
              v-model="item.company"
              type="text"
              class="form-control form-control-sm"
            />
          </div>
        </div>
        <div class="mb-3 row">
          <label class="col-3 col-form-label">Testimonial</label>
          <div class="col-8">
            <textarea
              v-model="item.text"
              class="form-control form-control-sm"
            ></textarea>
          </div>
        </div>
        <button
          v-if="testimonials.length > count"
          type="button"
          class="btn btn-danger btn-sm my-2 removeLogo"
          @click="removeTest(index)"
        >
          Remove
        </button>
      </div>
    </div>
    <button type="button" class="btn btn-primary btn-sm my-2" @click="addItem">
      Add New
    </button>
  </div>
</template>

<script>
export default {
  data: () => ({
    count: 2,
    testimonialObj: {
      customer: "",
      company: "",
      text: "",
    },
    validateField: false,
  }),
  props: ["testimonials", "testimonialValidate"],
  mounted() {
    for (let index = 0; index < this.count; index++) {
      this.testimonials.push({ ...this.testimonialObj });
    }
    this.applyTestimonialValidateWatcher();
  },
  methods: {
    addItem() {
      this.testimonials.push({ ...this.testimonialObj });
    },
    removeTest(index) {
      this.testimonials.splice(index, 1);
    },
    validate() {
      if (
        this.testimonials[0]?.customer != "" &&
        this.testimonials[0]?.company != "" &&
        this.testimonials[0]?.text != ""
      ) {
        this.validateField = true;
      } else {
        this.validateField = false;
      }
      this.$emit("update:testimonialValidate", this.validateField);
    },
    applyTestimonialValidateWatcher() {
      this.$watch("testimonials", {
        handler: function () {
          this.validate();
        },
        deep: true,
      });
    },
  },
};
</script>
