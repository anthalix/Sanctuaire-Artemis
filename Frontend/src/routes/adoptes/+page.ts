import type { PageLoad } from './$types';
import { getApiUrl } from '$lib/getApiUrl.js';
import { getBaseUrl } from '$lib/getBaseUrl.js';

export const load: PageLoad = async ({ fetch }) => {
	const API_URL = await getApiUrl();
	const BASE_URL = await getBaseUrl();

	const res = await fetch(`${API_URL}/adopted`);

	if (!res.ok) {
		return {
			adoptes: [],
			error: 'Impossible de charger les animaux adoptés'
		};
	}

	const adoptes = await res.json();

	return {
		adoptes,
		BASE_URL
	};
};
