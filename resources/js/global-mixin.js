import ProfileImage from './components/ProfileImage';
import Loading from 'vue-loading-overlay';
import 'vue-loading-overlay/dist/vue-loading.css';
var relativeTime = require('dayjs/plugin/relativeTime');
import { Link as RouterLink } from '@inertiajs/inertia-vue';

export default {
	components:{
		ProfileImage,
		Loading,
		RouterLink
	},
	data(){
		return {
			showMobileLogoBar:true,
			reportColorCodes: ['#10069F', '#963CBD', '#00C1D5', '#F39C12', '#1D7BB9', '#95A5A6', '#EABD0A'],
			reportColorClasses: [
				'text-blue',
				'text-accent',
				'text-dark-cyan',
				'text-dark-yellow',
				'text-nice-blue',
				'text-metal',
				'text-light-yellow',
			],
		};
	},
	computed: {
		baseUrl() {
			return this.$page.props.baseUrl;
		},
		fileUrl() {
			return this.$page.props.fileUrl;
		},
		signedIn(){
			return this.$page.props.signedIn;
		},
		AuthUser(){
			return this.$page.props.AuthUser;
		},
		AuthStudent(){
			return this.$page.props.AuthStudent;
		},
		AuthTeacher(){
			return this.$page.props.AuthTeacher;
		},
		csrfToken() {
			return this.$page.props.csrfToken;
		},
		accessToken() {
			return localStorage.getItem('access_token');
		},
		catchResponse(err){
			switch (err.response.status) {
			case 401:
				this.redirect('/login');
				break;
			case 422:
				let fieldErrors = [];
				for (let [index, field] of Object.entries(err.response.data.errors)) {
					fieldErrors = field.map(msg => {
						return { 'field': index, msg };
					});
					field = this.$validator.fields.find({ name: index });
					fieldErrors.forEach(error => {
						error.id = field.id;
						this.errors.add(error);
					});
					field.setFlags({
						valid: !!fieldErrors.length,
						dirty: true
					});
				};
				break;
			default:
				console.error('Error code:' + err.response.status); // eslint-disable-line no-console
				console.error(err.response.data); // eslint-disable-line no-console
				break;
			}
			return true;
		},
		letters() {
			let letters = [];
			for (let i = 'A'.charCodeAt(0); i <= 'Z'.charCodeAt(0); i++) {
				letters.push(String.fromCharCode([i]));
			}
			return letters;
		},
	},
	mounted(){
		this.axios.defaults.headers.common = {
			'X-CSRF-TOKEN': this.csrfToken,
			'X-Requested-With': 'XMLHttpRequest'
		};
		this.$dayjs.extend(relativeTime);
		var prevScrollpos = window.pageYOffset;
		window.addEventListener('scroll', ()=>{
			let headerMobile = document.getElementById('mobileNavbar');
			if (headerMobile){
				var currentScrollPos = window.pageYOffset;
				if (prevScrollpos > currentScrollPos) {
					this.showMobileLogoBar = true;
				} else {
					this.showMobileLogoBar = false;
				}
				prevScrollpos = currentScrollPos;
			}
		});
		document.addEventListener('click', this.closeSidebar);
	},
	methods: {
		'$trans':function(file,string,defaultString){
			return window.lang[file][string] ? window.lang[file][string] : (defaultString ? defaultString : string);
		},
		redirectPostView(post){
			document.title = post.heading;
		},
		
		formatDuration(time){
			let arr = time.split(':');
			let min = arr[1];
			let sec = arr[2];
			sec = sec.substr(0,2);

			return min+'min '+sec+'sec';
		},
		divideArrayIntoSubgroups(array,label){
			return array.map(node=>{
				new_node=[];
				let label_index = new_node.findIndex(node2=>node2[label]===node[label]);
				if(label_index > -1){
					new_node[label_index]['subgroup'] = [];
					new_node[label_index]['subgroup'].push(node);
				}else{
					let subgroup = [];
					subgroup.push(node);
					new_node.push({
						'key':node[label],
						'subgroup':subgroup,
					});
				}
				return new_node;
			});
		}
	}
};