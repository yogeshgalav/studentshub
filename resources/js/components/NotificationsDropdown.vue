<template>
  <div style="width:20px;">
    <div class="btn-group dropdown dropdown-notifications sw-open">
      <button
        class="btn dropdown-toggle border-radius-12 custom-pad"
        data-toggle="dropdown"
      >
        <i class="far fa-bell notification-icon" />
      </button>

      <div class="dropdown-container">
        <ul class="dropdown-menu notifications mobile_hide">
          <notification
            v-for="notification in notifications"
            :key="notification.id"
            :notification="notification"
            @read="markAsRead(notification)"
          />
          <li
            v-if="!notifications.length"
            class="notification"
          >
            <div class="media">
              <div class="media-body">
                <p class="notification-desc">
                  There is not notification
                </p>
              </div>
            </div>
          </li>
        </ul>
      </div>
    </div>
  </div>
</template>
<style scoped>
/*!
 * bootstrap-notifications v0.9.0 (https://skywalkapps.github.io/bootstrap-notifications)
 * Copyright 2016 Martin Staněk
 * Licensed under MIT
 */
.notification-system .dropdown-container {
    position: absolute;
    top: 100%;
    left: 0;
    z-index: 1000;
    display: none;
    float: left;
    margin: 2px 0 0;
    list-style: none;
    font-size: 14px;
    background-color: #fff;
    border: 1px solid #ccc;
    border: 1px solid rgba(0, 0, 0, 0.15);
    border-radius: 4px;
    -webkit-box-shadow: 0 6px 12px rgba(0, 0, 0, 0.175);
    box-shadow: 0 6px 12px rgba(0, 0, 0, 0.175);
    background-clip: padding-box;
}
.custom-pad {
    padding: 0.25rem 0.5rem !important;
    font-size: 0.7875rem !important;
    line-height: 1.5;
}
.notification-system .dropdown-container > .dropdown-menu {
    position: static;
    z-index: 1000;
    float: none !important;
    padding: 10px 0;
    margin: 0;
    border: 0;
    background: transparent;
    border-radius: 0;
    -webkit-box-shadow: none;
    box-shadow: none;
    max-height: 330px;
    overflow-y: auto;
}
.notification-system .dropdown-container > .dropdown-menu + .dropdown-menu {
    padding-top: 0;
}
.notification-system .dropdown-menu > li > a {
    overflow: hidden;
    white-space: nowrap;
    word-wrap: normal;
    text-decoration: none;
    text-overflow: ellipsis;
    -o-text-overflow: ellipsis;
    -webkit-transition: none;
    -o-transition: none;
    transition: none;
}
.notification-system .dropdown-toggle {
    cursor: pointer;
}
.notification-system .dropdown-header {
    white-space: nowrap;
}
.notification-system .open > .dropdown-container > .dropdown-menu,
.notification-system .open > .dropdown-container {
    display: block;
}
.notification-system .dropdown-toolbar {
    padding-top: 6px;
    padding-left: 20px;
    padding-right: 20px;
    padding-bottom: 5px;
    background-color: #fff;
    border-bottom: 1px solid rgba(0, 0, 0, 0.15);
    border-radius: 4px 4px 0 0;
}
.notification-system .dropdown-toolbar > .form-group {
    margin: 5px -10px;
}
.notification-system .dropdown-toolbar .dropdown-toolbar-actions {
    float: right;
}
.notification-system .dropdown-toolbar .dropdown-toolbar-title {
    margin: 0;
    font-size: 14px;
}
.notification-system .dropdown-footer {
    padding: 5px 20px;
    border-top: 1px solid #ccc;
    border-top: 1px solid rgba(0, 0, 0, 0.15);
    border-radius: 0 0 4px 4px;
}
.notification-system .anchor-block small {
    display: none;
}
.notification-icon {
    font-size: x-large;
}
@media (max-width: 500px) {
    .notification-icon {
        font-size: 25px;
    }
}
@media (min-width: 992px) {
    .notification-system .anchor-block small {
        display: block;
        font-weight: normal;
        color: #777777;
    }
    .notification-system .dropdown-menu > li > a.anchor-block {
        padding-top: 6px;
        padding-bottom: 6px;
    }
}
@media (min-width: 992px) {
    .notification-system .dropdown.hoverable:hover > ul {
        display: block;
    }
}
.notification-system .dropdown-position-topright {
    top: auto;
    right: 0;
    bottom: 100%;
    left: auto;
    margin-bottom: 2px;
}
.notification-system .dropdown-position-topleft {
    top: auto;
    right: auto;
    bottom: 100%;
    left: 0;
    margin-bottom: 2px;
}
.notification-system .dropdown-position-bottomright {
    right: 0;
    left: auto;
}
.notification-system .dropmenu-item-label {
    white-space: nowrap;
}
.notification-system .dropmenu-item-content {
    position: absolute;
    text-align: right;
    max-width: 60px;
    right: 20px;
    color: #777777;
    overflow: hidden;
    white-space: nowrap;
    word-wrap: normal;
    -o-text-overflow: ellipsis;
    text-overflow: ellipsis;
}
small.dropmenu-item-content {
    line-height: 20px;
}
.dropdown-menu > li > a.dropmenu-item {
    position: relative;
    padding-right: 66px;
}
.notification-system .dropdown-submenu .dropmenu-item-content {
    right: 40px;
}
.notification-system .dropdown-menu > li.dropdown-submenu > a.dropmenu-item {
    padding-right: 86px;
}
.notification-system .dropdown-inverse .dropdown-menu {
    background-color: rgba(0, 0, 0, 0.8);
    border: 1px solid rgba(0, 0, 0, 0.9);
}
.notification-system .dropdown-inverse .dropdown-menu .divider {
    height: 1px;
    margin: 9px 0;
    overflow: hidden;
    background-color: #2b2b2b;
}
.notification-system .dropdown-inverse .dropdown-menu > li > a {
    color: #cccccc;
}
.notification-system .dropdown-inverse .dropdown-menu > li > a:hover,
.dropdown-inverse .dropdown-menu > li > a:focus {
    color: #fff;
    background-color: #262626;
}
.dropdown-inverse .dropdown-menu > .active > a,
.dropdown-inverse .dropdown-menu > .active > a:hover,
.dropdown-inverse .dropdown-menu > .active > a:focus {
    color: #fff;
    background-color: #337ab7;
}
.dropdown-inverse .dropdown-menu > .disabled > a,
.dropdown-inverse .dropdown-menu > .disabled > a:hover,
.dropdown-inverse .dropdown-menu > .disabled > a:focus {
    color: #777777;
}
.dropdown-inverse .dropdown-header {
    color: #777777;
}
.table > thead > tr > th.col-actions {
    padding-top: 0;
    padding-bottom: 0;
}
.table > thead > tr > th.col-actions .dropdown-toggle {
    color: #777777;
}
.notifications {
    list-style: none;
    padding: 0;
}
.notification {
    display: block;
    padding: 9.6px 12px;
    border-bottom: 1px solid #eeeeee;
    color: #333333;
    text-decoration: none;
}
.notification:last-child {
    border-bottom: 0;
}
.notification:hover,
.notification.active:hover {
    background-color: #f9f9f9;
}
.notification.active {
    background-color: #f4f4f4;
}
.notification-title {
    font-size: 15px;
    margin-bottom: 0;
}
.notification-desc {
    margin-bottom: 0;
}
.notification-meta {
    color: #777777;
}
a.notification:hover {
    text-decoration: none;
}
.dropdown-notifications > .dropdown-container,
.dropdown-notifications > .dropdown-menu {
    width: 250px;
    max-width: 250px;
}
.dropdown-notifications .dropdown-menu {
    padding: 0;
}
.dropdown-notifications .dropdown-toolbar,
.dropdown-notifications .dropdown-footer {
    padding: 9.6px 12px;
}
.dropdown-notifications .dropdown-toolbar {
    background: #fff;
}
.dropdown-notifications .dropdown-footer {
    background: #eeeeee;
}
.notification-icon {
    margin-right: 6.8775px;
}
.notification-icon:after {
    position: absolute;
    content: attr(data-count);
    margin-left: -6.8775px;
    margin-top: -6.8775px;
    padding: 0 4px;
    min-width: 13.755px;
    height: 13.755px;
    line-height: 13.755px;
    background: red;
    border-radius: 10px;
    color: #fff;
    text-align: center;
    vertical-align: middle;
    font-size: 11.004px;
    font-weight: 600;
    font-family: "Helvetica Neue", Helvetica, Arial, sans-serif;
}
.notification .media-body {
    padding-top: 5.6px;
}
.btn-lg .notification-icon:after {
    margin-left: -8.253px;
    margin-top: -8.253px;
    min-width: 16.506px;
    line-height: 16.506px;
    font-size: 13.755px;
}
.btn-xs .notification-icon:after {
    content: "";
    margin-left: -4.1265px;
    margin-top: -2.06325px;
    min-width: 6.25227273px;
    line-height: 6.25227273px;
    padding: 0;
}
.btn-xs .notification-icon {
    margin-right: 3.43875px;
}
@media (max-width: 640px) {
    .mobile_hide {
        display: none;
    }
    .fa-angle-down {
        display: none;
    }
}
</style>
<script>
import $ from 'jquery';
import axios from 'axios';
import Notification from './Notification';

export default {
	components: { Notification },

	data: () => ({
		total: 0,
		notifications: []
	}),

	computed: {
		hasUnread() {
			return this.total > 0;
		}
	},

	mounted() {
		this.fetch();

		if (window.Echo) {
			this.listen();
		}

		this.initDropdown();
	},

	methods: {
		/**
         * Fetch notifications.
         *
         * @param {Number} limit
         */
		fetch(limit = 5) {
			axios
				.get('/api/notifications', { params: { limit } })
				.then(({ data: { total, notifications } }) => {
					this.total = total;
					this.notifications = notifications.map(
						({ id, data, created }) => {
							return {
								id: id,
								title: data.title,
								body: data.body,
								created: created,
								action_url: data.action_url
							};
						}
					);
				});
		},

		/**
         * Mark the given notification as read.
         *
         * @param {Object} notification
         */
		markAsRead({ id }) {
			const index = this.notifications.findIndex(n => n.id === id);

			if (index > -1) {
				this.total--;
				this.notifications.splice(index, 1);
				axios.patch(`/api/notifications/${id}/read`);
			}
		},

		/**
         * Mark all notifications as read.
         */
		markAllRead() {
			this.total = 0;
			this.notifications = [];

			axios.post('/api/notifications/mark-all-read');
		},

		/**
         * Listen for Echo push notifications.
         */
		listen() {
			window.Echo.private('App.User.' + AuthUser.id)
				.notification(notification => {
					this.total++;
					this.notifications.unshift(notification);
				})
				.listen('NotificationRead', ({ notificationId }) => {
					this.total--;

					const index = this.notifications.findIndex(
						n => n.id === notificationId
					);
					if (index > -1) {
						this.notifications.splice(index, 1);
					}
				})
				.listen('NotificationReadAll', () => {
					this.total = 0;
					this.notifications = [];
				});
		},

		/**
         * Initialize the notifications dropdown.
         */
		initDropdown() {
			const dropdown = $(this.$refs.dropdown);

			$(document).on('click', e => {
				if (
					!dropdown.is(e.target) &&
                    dropdown.has(e.target).length === 0 &&
                    !$(e.target)
                    	.parent()
                    	.hasClass('notification-mark-read')
				) {
					dropdown.removeClass('open');
				}
			});
		},

		/**
         * Toggle the notifications dropdown.
         */
		toggleDropdown() {
			$(this.$refs.dropdown).toggleClass('open');
		}
	}
};
</script>
