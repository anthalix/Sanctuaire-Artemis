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
  status:string;
  taille:string;
}
export const load = async ({ fetch, params }) => {
  const res = await fetch(`http://localhost:8000/api/animal/${params.id}`);

  if (!res.ok) {
    throw new Error('Animal not found');
  }

  const animal: Animal = await res.json();
  return { animal };
};

