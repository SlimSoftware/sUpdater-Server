import axios from 'axios';

export default {
    install: () => {
        axios.defaults.withCredentials = true;
        axios.defaults.withXSRFToken = true;
        axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';
    },
};
