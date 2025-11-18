export interface Breed {
	id: number;
	name: string;
}

export interface Specie {
	id: number;
	name: string;
}

export interface Cat {
	id: number;
	name: string;
	age: number;
	description: string;
	sex: string;
	child: boolean;
	cat: boolean;
	dog: boolean;
	thumbnail: string;
	specie: Specie;
	breeds: Breed[];
	status: string;
	taille: string;
}

import { getApiUrl } from '$lib/getApiUrl.js';
import { getBaseUrl } from '$lib/getBaseUrl.js';

export const load = async ({ fetch }) => {
	const API_URL = await getApiUrl();
	const BASE_URL = await getBaseUrl();
	const res = await fetch(`${API_URL}/cats`);
	const cats: Cat[] = await res.json();
	return { cats, BASE_URL };
};
