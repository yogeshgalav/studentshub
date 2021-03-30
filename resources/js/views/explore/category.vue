<template>
  <div>
    <div>{{ category_name }}</div>
    <nav-tabs
      :tabs="tabs"
      :initial-tab="initialTab"
    />
  </div>
</template>
<style scoped></style>
<script>
import SiteFooter from '../footer/SiteFooter';
import NavTabs from '../../components/NavTabs';
export default {
	components: {
		SiteFooter,
		NavTabs
	},
	data() {
		return {
			category_name: '',
			email: '',
			description: '',
			showLoader: false
		};
	},
	mounted() {
		console.log(this.$route.params.url);
		this.axios
			.get('/api/get-category-details/' + this.$route.params.url)
			.then(resp => {
				this.category_name = resp.data.success.category.name;
			});
	},
	methods: {
		handleSubmit() {
			this.$validator.validate().then(valid => {
				if (valid) {
					this.axios
						.post('/api/contactus', {
							name: this.AuthUser
								? this.AuthUser.full_name
								: this.name,
							email: this.AuthUser
								? this.AuthUser.email
								: this.email,
							description: this.description
						})
						.then(resp => {
							window.location.href = '/';
						})
						.catch(err => {});
				}
			});
		}
	}
};
</script>
