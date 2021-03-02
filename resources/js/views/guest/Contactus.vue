
<template>
  <div>
    <div class="blank"></div>
    <header class="heading">
      <h1>
        We help Students, Teachers and Institutes to Find Pain Points and Boost
        Productivity.
      </h1>
    </header>
    <div class="">
      <div class="row" style="background: black">
        <div class="col-6">
          <div class="mapouter">
            <div class="gmap_canvas">
              <iframe
                width="100%"
                height="500"
                id="gmap_canvas"
                src="https://maps.google.com/maps?q=26.9024375%2075.78706249999999&t=&z=11&ie=UTF8&iwloc=&output=embed"
                frameborder="0"
                scrolling="no"
                marginheight="0"
                marginwidth="0"
              ></iframe
              ><a
                href="https://yt2.org/youtube-to-mp3-ALeKk00qEW0sxByTDSpzaRvl8WxdMAeMytQ1611842368056QMMlSYKLwAsWUsAfLipqwCA2ahUKEwiikKDe5L7uAhVFCuwKHUuFBoYQ8tMDegUAQCSAQCYAQCqAQdnd3Mtd2l6"
              ></a
              ><br />
            </div>
          </div>
        </div>
        <div class="col right">
          <p>
            1, Patel Nagar<br />
            22 Godam, Hawa Sadak,<br />
            Jaipur, Rajasthan, 302006
          </p>
          <p>
            Mobile: +91 8003345821<br />
            Email: info@studentshub.in
          </p>
        </div>
      </div>
    </div>

    <main>
      <div class="col-md-12">
        <div class="row justify-content-center">
          <div class="col-md-6 mt-100 p-2">
            <div class="form">
              <div class="form-head">
                <h2>Contact Us</h2>
              </div>
              <hr />
              <form @submit.prevent="handleSubmit">
                <div class="field">
                  <label for="Name">{{ "Name" }}</label>

                  <div>
                    <input
                      id="name"
                      ref="name"
                      v-model="name"
                      v-validate="'required|max:30'"
                      type="name"
                      class="form-control"
                      name="name"
                    />
                  </div>
                </div>
                <div class="field">
                  <label for="email">Email</label>

                  <div>
                    <input
                      id="email"
                      v-model="email"
                      v-validate="'required|email'"
                      type="email"
                      class="form-control"
                      name="email"
                    />
                    <span class="error">{{ formErrors("email") }}</span>
                  </div>
                </div>
                <div class="field">
                  <label for="descrption">Description</label>

                  <div>
                    <textarea
                      id="discription"
                      v-model="description"
                      type="description"
                      class="form-control"
                      name="description"
                      rows="8"
                      cols="80"
                    ></textarea>
                  </div>
                </div>
                <hr />
                <div class="button">
                  <button
                    type="submit"
                    class="btn btn-primary"
                    style="width: 100px"
                  >
                    {{ "Send" }}
                  </button>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
      <div class="col-md-12">
        <div class="divider mt-5"></div>
      </div>
      <site-footer />
    </main>
  </div>
</template>
<style scoped>
.mt-100 {
  margin-top: 200px;
}

.right {
  text-align: left;
  height: 500px;
  background: black;
  color: azure;
  padding-left: 2%;
  padding: 12% 0 2% 5%;
  font-size: 20px;
}
h2 {
  font-weight: 500;
  text-align: center;
  color: white;
}
input {
  border-radius: 0%;
}
.field {
  margin-top: 10px;
  margin-left: 10px;
  margin-right: 10px;
}
hr {
  color: black;
  height: 10px;
  margin-top: -2px;
  background: royalblue;
  margin-bottom: auto;
}
.button {
  height: 85px;
  display: flex;
  align-items: center;
  background: black;
  justify-content: center;
}
.mapouter {
  position: relative;
  text-align: right;
  height: 500px;
  width: 100%;
}
.gmap_canvas {
  overflow: hidden;
  background: none !important;
  height: 500px;
  width: 100%;
}
.form {
  max-width: 400px;
  margin: auto;
  background: whitesmoke;
}
.form-head {
  height: 85px;
  align-items: center;
  background: black;
  justify-content: center;
  padding-top: 12px;
}
.heading {
  min-height: 500px;
  padding: 5%;
  background: black;
  margin-bottom: 30px;
  width: 100%;
}

h1 {
  text-align: center;
  color: white;
  font-weight: 600;
  letter-spacing: 2px;
  height: 90px;
}
.blank {
  height: 60px;
}
</style>
<script>
import FormMixin from "../../components/mixins/form-mixin.js";
import SiteFooter from "../footer/SiteFooter";
export default {
  mixins: [FormMixin],
  name: "contactus",
  components: {
    SiteFooter,
  },
  data() {
    return {
      name: "",
      email: "",
      description: "",
    };
  },
  methods: {
    handleSubmit() {
      this.$validator.validate().then((valid) => {
        if (valid) {
          this.axios
            .post("/api/contactus", {
              name: this.name,
              email: this.email,
              description: this.description,
            })
            .then((resp) => {
              window.location.href = "/";
            })
            .catch((err) => {});
        }
      });
    },
  },
};
</script>
