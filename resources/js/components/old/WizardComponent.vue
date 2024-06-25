<template>
  <div class="container text-start mb-5">
    <form action="#">
      <div class="row justify-content-md-center formbold-form-step-1 wizard-form active" step-id="1">
        
        <div class="col-12 text-center">
          <img src="/frontend/images/design.png" class="img-fluid mb-4" />
        </div>
        <div class="col-8 ps-5 text-center">
          <div class="mb-3 row">
            <label class="col-5 col-form-label p-0"
              >Select Your Preferred Design</label
            >
            <div class="col-7">
              <div class="form-check form-check-inline">
                <input
                  v-model="formData['design_option']"
                  class="form-check-input"
                  type="radio"
                  name="design_option"
                  id="inlineRadio1"
                  value="1"
                  required
                />
                <label class="form-check-label" for="inlineRadio1"
                  >Design 1</label
                >
              </div>
              <div class="form-check form-check-inline">
                <input
                  v-model="formData['design_option']"
                  class="form-check-input"
                  type="radio"
                  name="design_option"
                  id="inlineRadio2"
                  value="2"
                  required
                />
                <label class="form-check-label" for="inlineRadio2"
                  >Design 2</label
                >
              </div>
              <div class="form-check form-check-inline">
                <input
                  v-model="formData['design_option']"
                  class="form-check-input"
                  type="radio"
                  name="design_option"
                  id="inlineRadio3"
                  value="3"
                  required
                />
                <label class="form-check-label" for="inlineRadio3"
                  >Design 3</label
                >
              </div>
              <div class="form-check form-check-inline">
                <input
                  v-model="formData['design_option']"
                  class="form-check-input"
                  type="radio"
                  name="design_option"
                  id="inlineRadio4"
                  value="4"
                  required
                />
                <label class="form-check-label" for="inlineRadio4"
                  >Design 4</label
                >
              </div>
            </div>
          </div>
        </div>
      </div>

      <div class="row formbold-form-step-2 wizard-form " step-id="2">
        <div class="col-6">
          <img src="/frontend/images/1.jpeg" class="img-fluid" />
        </div>
        <div class="col-6 ps-5">
          <div class="mb-3 row text-start">
            <label class="col-5 col-form-label ps-0"
              >Upload Your Business Logo</label
            >
            <div class="col-7">
              <input
                v-on:change="onFileChange"
                class="form-control form-control-sm"
                type="file"
                name="logo"
                accept="image/png, image/jpeg"
                required
              />
            </div>
          </div>
          <div class="mb-3 row">
            <label class="col-5 col-form-label ps-0">Preferred color
              <div class="form-text">
                We will be getting the colors from the logo you uploaded,If you don't have a logo please select colors
              </div>
            </label>
            <div class="col-7">
              <div v-for="(item, index) in colors" :key="index" class="form-check">
                <input v-model="item.checked" class="form-check-input" type="checkbox" :value="item.name" v-bind:id="item.name" @change="checkColor($event)">
                <label v-if="item.name!=''" class="form-check-label" :for="item.name">
                {{ item.name }}
                </label>
                <label v-else class="form-check-label">
                  <input
                    v-model="customColor"
                    type="text"
                    class="form-control form-control-sm"
                  />
                </label>
              </div>           
            </div>
          </div>
          <div class="mb-3 row">
            <label class="col-5 col-form-label ps-0">Caption</label>
            <div class="col-7">
              <input
                v-model="formData['caption']"
                type="text"
                class="form-control form-control-sm"
                name="caption"
                required
              />
              <div class="form-text">
                ex: – "Mortgage Broker for Western Australian Families"
              </div>
            </div>
          </div>
          <div class="mb-3 row">
            <label class="col-5 col-form-label ps-0">Sub caption</label>
            <div class="col-7">
              <input
                v-model="formData['subCaption']"
                type="text"
                class="form-control form-control-sm"
                name="subCaption"
                required
              />
              <div class="form-text">
                ex: – "Elevate your experience with us. Unlock Possibilities, Acheive Excellence."
              </div>
            </div>
          </div>
        </div>
      </div>

      <div class="row formbold-form-step-3 wizard-form " step-id="3">
        <div class="col-6">
          <img src="/frontend/images/2.jpeg" class="img-fluid" />
        </div>
        <ServicesComponent :services="services" />
      </div>

      <div class="row formbold-form-step-4 wizard-form " step-id="4">
        <div class="col-6 text-start">
          <img src="/frontend/images/3.jpeg" class="img-fluid" />
          <div class="form-text">
            (If you have a process from the start of client contact to the
            settlement)
          </div>
          <div class="form-text">
            Please provide us with the number of steps based on the design chosen
            (some designs have 3 steps )
          </div>
          <div class="form-text">Describe each step in less than 12 words</div>
        </div>
        <ProcessesComponent :processes="processes" />
      </div>

      <div class="row formbold-form-step-5 wizard-form text-start " step-id="5">
        <div class="col-6">
          <img src="/frontend/images/4.jpeg" class="img-fluid" />
        </div>
        <div class="col-6">
          <div class="mb-3 row">
            <h5 class="card-title text-start">About Us</h5>
            <div class="form-text">
              Describe your business in not more than 6 - 7 lines as per the given image
            </div>
            <div class="input-group">
              <textarea
                v-model="formData['about']"
                class="form-control"
                style="height: 100px"
                name="about"
              ></textarea>
            </div>
          </div>
          <h6 class="card-title text-start">Qualifications(Optional)</h6>
          <div class="form-text text-start">
            Let us know of any awards/compliance details (ISO)/Qualifications etc
            that we should highlight
          </div>
          <QualificationsComponent :qualifications="qualifications" />
        </div>
      </div>

      <div class="row formbold-form-step-6 wizard-form " step-id="6">
        <div class="col-6">
          <img src="/frontend/images/5.jpeg" class="img-fluid" />
        </div>
        <PartnersComponent :partners="partners" />
      </div>

      <div class="row formbold-form-step-7 wizard-form " step-id="7">
        <div class="col-6">
          <img src="/frontend/images/6.jpeg" class="img-fluid" />
        </div>
        <div class="col-6">
          <h5 class="card-title text-start mb-2">Testimonials(Optional)</h5>
          <div class="form-text text-start mb-2">
            Please give us atleast 1 testmonial,3-5 will be great <br> You can add more as you get them.
          </div>
          <TestimonialsComponent :testimonials="testimonials" />
        </div>
      </div>

      <div class="row formbold-form-step-8 wizard-form " step-id="8">
        <div class="col-6">
          <img src="/frontend/images/7.jpeg" class="img-fluid" />
        </div>
        <div class="col-6 text-start">
          <h5 class="card-title text-start mb-2">
            Call to Action and Contact Details
          </h5>
          <div class="form-text text-start mb-2">
            Let us know the information for the below sections
          </div>
          <div class="mb-3 row">
            <label class="col-3 col-form-label">Name</label>
            <div class="col-6">
              <input
                v-model="formData['contact_name']"
                type="text"
                class="form-control form-control-sm"
              />
            </div>
          </div>
          <div class="mb-3 row">
            <label class="col-3 col-form-label">Phone</label>
            <div class="col-6">
              <input
                v-model="formData['contact_phone']"
                type="text"
                class="form-control form-control-sm"
              />
            </div>
          </div>
          <div class="mb-3 row">
            <label class="col-3 col-form-label">Email</label>
            <div class="col-6">
              <input
                v-model="formData['contact_email']"
                type="email"
                class="form-control form-control-sm"
              />
            </div>
          </div>
          <h6 class="card-title text-start my-2">Social account links(Optional)</h6>
          <div
            v-for="(item, index) in socialMedia"
            :key="index"
            class="form-floating mb-3"
          >
            <input
              v-model="item.url"
              type="text"
              class="form-control"
              placeholder="Facebook"
            />
            <label>{{ item.type }}</label>
          </div>
        </div>
      </div>

      <div
        class="row justify-content-md-center formbold-form-step-9 wizard-form "
        step-id="9"
      >
        <div class="col-6">
          <h5 class="card-title text-start mb-2">Ideal Customer Types</h5>
          <div class="form-text text-start mb-2">
            Tell us about the ideal customers you would like to win - these help
            us to get the imagery right
          </div>
          <div class="mb-3 row text-start">
            <label class="col-4 col-form-label">Age Group</label>
            <div class="col-6">
              <input
                v-model="formData['age_group']"
                type="text"
                class="form-control form-control-sm"
              />
            </div>
          </div>
          <div class="mb-3 row">
            <label class="col-4 col-form-label">Gender</label>
            <div class="col-6">
              <select
                class="form-select form-select-sm"
                aria-label="Small select example"
                v-model="formData['gender']"
              >
                <option value="Male">Male</option>
                <option value="Female">Female</option>
                <option value="Both">Both</option>
              </select>
            </div>
          </div>
          <div class="mb-3 row">
            <label class="col-4 col-form-label">Ethnicity</label>
            <div class="col-6">   
              <input
                v-model="formData['ethnicity']"
                type="text"
                class="form-control form-control-sm"
                name="professions"
              />        
            </div>
          </div>
          <div class="mb-3 row">
            <label class="col-4 col-form-label">Professions</label>
            <div class="col-6">
              <input
                v-model="formData['professions']"
                type="text"
                class="form-control form-control-sm"
                name="professions"
              />
            </div>
          </div>
          <div class="mb-3 row">
            <label class="col-4 col-form-label">What their interests are</label>
            <div class="col-6">
              <textarea
                v-model="formData['interests']"
                class="form-control form-control-sm"
                name="interests"
              ></textarea>
            </div>
          </div>
          <div class="mb-3 row">
            <label class="col-4 col-form-label"
              >What do you think they want to achieve (if you know )</label
            >
            <div class="col-6">
              <textarea
                v-model="formData['achievements']"
                class="form-control form-control-sm"
                name="achievements"
              ></textarea>
            </div>
          </div>
        </div>
      </div>

      <div class="row text-center mt-5 p-5 formbold-form-step-10 wizard-form " step-id="10">
        <div class="col-12">
          <h1>Submission Successful <span class="material-symbols-outlined text-success fs-1">task_alt</span></h1>
          <p>Your information has been successfully submitted.</p>
          <p>
            If you have any questions or need further assistance, please do not
            hesitate to contact us.
          </p>
          <p>Thank you.</p>
        </div>
      </div>

      <div class="row formbold-form-btn-wrapper">
        <div class="col-12 text-center">
          <button class="btn btn-sm formbold-back-btn float-start">Back</button>

          <button class="btn btn-sm formbold-edit-btn">Edit</button>

          <button
            type="submit"
            class="btn btn-sm formbold-btn formbold-next float-end"
            @click="nextClick"
          >
            Next Step
          </button>
        </div>
      </div>
    </form>

  </div>
</template>

<script>
import axios from "axios";
import PartnersComponent from "./PartnersComponent";
import ServicesComponent from "./ServicesComponent";
import ProcessesComponent from "./ProcessesComponent";
import QualificationsComponent from "./QualificationsComponent";
import TestimonialsComponent from "./TestimonialsComponent";
export default {
  data: () => ({
    formData: {
      colors: [],
      services: [],
      processes: [],
      qualifications: [],
      partners: [],
      testimonials: []
    },
    fdata: new FormData(),
    logo: null,
    partners: [],
    services: [],
    processes: [],
    qualifications: [],
    testimonials: [],
    socialMedia: [
      {
        type: "Facebook",
        url: "",
      },
      {
        type: "X",
        url: "",
      },
      {
        type: "Instagram",
        url: "",
      },
    ],
    colors: [
      {
        name: "Red"
      },
      {
        name: "Blue"
      },
      {
        name: "Yellow"
      },
      {
        name: "Green"
      },
      {
        name: "Orange"
      },
      {
        name: "Purple"
      },
      {
        name: "Brown"
      },
      {
        name: "Pink"
      },
      {
        name: ""
      }
    ],
    result: {},
    formSubmit: false,
    _colors: [],
    customColor: ''
  }),
  components: {
    PartnersComponent,
    ServicesComponent,
    ProcessesComponent,
    QualificationsComponent,
    TestimonialsComponent,
  },
  watch: {
    customColor(){
      const index = this._colors.findIndex(item => item.custom)
      this._colors.splice(index, 1);
      const custom_color = {
        name: this.customColor,
        custom: true
      }
      this._colors.push(custom_color)
      console.log(this._colors)
    }
  },
  mounted() {
    this._colors = new Array()
    this._ethnicity = new Array()
  },
  methods: {
    nextClick() {
      if (this.services.length > 0)
        this.formData.services = JSON.stringify(this.services)
      if (this.processes.length > 0)
        this.formData.processes = JSON.stringify(this.processes)
      if (this.qualifications.length > 0)
        this.formData.qualifications = JSON.stringify(this.qualifications)
      if (this.partners.length > 0)
        this.formData.partners = JSON.stringify(this.partners)
      if (this.testimonials.length > 0)
        this.formData.testimonials = JSON.stringify(this.testimonials)
      if (this.socialMedia.length > 0)
        this.formData.socialMedia = JSON.stringify(this.socialMedia)
      if (this._colors.length > 0)
        this.formData.colors = JSON.stringify(this._colors)

      this.submit();
    },
    onFileChange(e) {
      var files = e.target.files || e.dataTransfer.files;
      if (!files.length) return;
      this.fdata.append("logo", files[0])
    },
    onColorChange(e) {
      this.formData.color = e.target.value
    },
    submit() {
      this.formSubmit = true;
      Object.entries(this.formData).forEach(([key, value]) => {
        this.fdata.append(key, value)
      })

      if (!Object.keys(this.result).length) {
        this.addNew()
      } else {
        this.update()
      }
      this.fdata.delete("logo")
    },
    addNew() {
      axios
        .post("api/form-submit", this.fdata)
        .then(({ data }) => {
          this.result = data
        })
        .catch((error) => {
          error = error.data.message;
        });
    },
    update() {
      axios
        .post("api/form-submit-update/" + this.result.id, this.fdata)
        .then(({ data }) => {
          this.result = data
        })
        .catch((error) => {
          error = error.data.message
        });
    },
    checkColor (event) {
      const color = {
        name: event.target.value
      }
      const i = this._colors.findIndex(e => e.name === color.name)
      if (i > -1) {
        this._colors.splice(i, 1)
      } else {
        this._colors.push(color)
      }
    }
  },
};
</script>
