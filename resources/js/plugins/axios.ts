import axios from 'axios';
import { useGlobalStore } from '../stores/global';

export default {
    install: () => {
        axios.defaults.baseURL = '/api/dashboard/';
        axios.defaults.withCredentials = true;
        axios.defaults.withXSRFToken = true;
        axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

        axios.interceptors.request.use((request) => {
            setIsLoading(true);
            return request;
        });

        axios.interceptors.response.use((response) => {
            setIsLoading(false);
            return response;
        });
    }
};

function setIsLoading(isLoading: boolean) {
    const globalStore = useGlobalStore();
    globalStore.isLoading = isLoading;
}
