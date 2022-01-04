<template>
  <main>
    <loading
      :active.sync="showLoader"
      :color="'#10069F'"
      :width="250"
      :is-full-page="true"
    />
    <div class="blank" />
    <div
      class="heading"
      style="background-image: url('/images/welcome/study-background.jpg');"
    >
      <h1 class="main_heading">
        Frequently Asked Questions
        <h2 class="second_heading">
          Need Help?
          We've got You covered
        </h2>
      </h1>
    </div>
    <div class="col-md-12">
      <div class="row justify-content-center">
        <div class="col-md-6 mt-3 p-2">
          <div
            v-for="(faq, index) in faqs"
            :key="index"
          >
            <div class="card">
              <div class="card-body">
                <h5 class="card-title">
                  <strong>Q.</strong> {{ faq.query.trim() }}
                </h5>
                <p class="card-text">
                  {{ faq.answer }}
                </p>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="form justify-content-center  mt-100">
      <form
        class="col-md-6"
        @submit.prevent="handleSubmit"
      >
        <div
          v-if="!AuthUser"
          class="form-group row"
        >
          <div class="col-md-12">
            <label
              for="email"
              class="col-form-label text-md-right"
            >{{ "Email" }}</label>
            <input
              id="email"
              v-model="email"
              v-validate="'required|email'"
              type="email"
              class="form-control"
              name="email"
            >
            <span class="text-danger"> {{ formErrors("email") }}</span>
          </div>
        </div>
        <div class="form-group row">
          <div class="col-md-12">
            <label
              for="query"
              class="col-form-label text-md-right"
            >
              Query
            </label>
            <textarea
              id="query"
              v-model="query"
              v-validate="'required'"
              type="text"
              rows="10"
              class="form-control"
              name="query"
            />
            <span class="text-danger"> {{ formErrors("query") }}</span>
          </div>
        </div>
        <div class="form-group row mb-0">
          <div class="col-md-8">
            <button
              type="submit"
              class="btn btn-primary"
            >
              {{ "Submit" }}
            </button>
          </div>
        </div>
      </form>
    </div>
  </main>
</template>


<script>
import FormMixin from '../../components/mixins/form-mixin.js';
import GuestLayout from '@/Layouts/GuestLayout.vue';

export default {
	name: 'Faq',
  layout: GuestLayout,
	mixins: [FormMixin],
	props: {
		faqs:{
			required: true,
			type: Object,
		}
	},
	data() {
		return {
			email: '',
			query: '',
			showLoader: false,
		};
	},
	methods: {
		handleSubmit() {
			this.$validator.validate().then((valid) => {
				if (valid) {
					this.showLoader = true;
					console.log(this.showLoader);
					this.axios
						.post('/api/faq', {
							email: this.AuthUser ? this.AuthUser.email : this.email,
							quer: this.query,
						})
						.then((resp) => {
							window.location.href = '/';
						})
						.catch((err) => {
							console.log(err);
						});
				}
			});
		},
	},
};
</script>

<style scoped>
.mt-100 {
  margin-top: 150px;
}
strong {
  font-size: 20px;
}
.card {
  margin-top: 20px;
}
input {
  border-radius: 0%;
}
.heading{
  display: flex;
  align-items: center;
  justify-content: center;
}
</style>
