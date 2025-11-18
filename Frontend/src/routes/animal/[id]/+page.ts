export interface Breed {
	id: number;
	name: string;
}

export interface Specie {
	id: number;
	name: string;
}

export interface Animal {
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
const API_URL = await getApiUrl();

export const load = async ({ fetch, params }) => {
	const res = await fetch(`${API_URL}/animal/${params.id}`);

	if (!res.ok) {
		throw new Error('Animal not found');
	}

	const animal: Animal = await res.json();
	return { animal };
};
