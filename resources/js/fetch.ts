import { ref } from 'vue';

export function useFetch(url: string) {
  const data = ref();
  const error = ref();

  fetch(url)
    .then((res) => res.json())
    .then((json) => (data.value = json))
    .catch((err) => (error.value = err));

  return { data, error };
}