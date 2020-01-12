import Vue from 'vue'
import VueI18n from 'vue-i18n'

Vue.use(VueI18n)

export const i18n = new VueI18n ({
    local: 'en',
    locale: 'en',
    fallbackLocale: 'en',
    silentTranslationWarn: true,
    messages: {

        // English 
        en: {
            csrfToken: document.getElementsByName('csrf-token')[0].value,
            auth: {
                name: 'Name',
                email_address: 'Email address',
                password: 'Password',
                remember_me: 'Remember me',
                login: 'Login',
                not_user: 'Not a user?',
                already_user: 'Already a user?',
                register: 'Register',
                submit: 'Submit',
                rememberd_password: 'Rememberd your password?',
                i_accpet: 'I Accpet our ',
                terms_condition: 'terms conditions',
                privacy_policy: 'privacy policy',
                new_password: 'New Password',
                con_new_password: 'Confirm New Password',
            },

            app: {
                dashboard: 'DASHBOARD',
                profile: 'PROFILE',
                logout: 'LOG OUT',
                search: 'SEARCH HERE...',
                submit: 'SUBMIT',
                update: 'UPDATE',
                cancel: 'CANCEL',
                active: 'ACTIVE',
                deactive: 'DEACTIVE',
                edit: 'EDIT',
                show: 'SHOW',
                delete: 'DELETE',
                suspend: 'SUSPEND',
                restore: 'RESTORE',
                try_again: 'Try again',
                all_data: 'ALL DATA',
                create_new: 'CREATE NEW',
                actions: 'ACTIONS',
                no_data: 'No data found.',
                success_msg: 'Yo-ho-ho!, <br/>Request Successfully Completed.',
                error_msg: 'Opps, <br/>Something went wrong.',
            },

            nav: {
                main: 'MAIN',
                dashboard: 'DASHBOARD',
                events: 'EVENTS',
                meetings: 'MEETINGS',
                calls: 'CALLS',
                users: 'USERS',
                members: 'MEMBERS',
                settings: 'SETTINGS',
                docs: 'DOCS',
            },

            

            members: {
                title: 'MEMBERS',
                image: 'IMAGE',
                name: 'NAME',
                email: 'EMAIL',
                registerd_at: 'REGISTERD AT',
            },

            settings: {
                name: 'SETTINGS',
                logo: 'LOGO',
                title: 'TITLE',
                email: 'EMAIL',
                mobile: 'MOBILE',
            },

        },

        // Feel free to add anothers languages here
        


    }
})