export interface Breed {
  id: number;
  name: string;
}

export interface Specie {
  id: number;
  name: string;
}

export interface Dog {
  id: number;
  name: string;
  age: number;
	taille: string;
	description: string;
  sex: string;
  child: boolean;
  cat: boolean;
  dog: boolean;
  thumbnail: string;
  specie: Specie;
  breeds: Breed[];
  status:string;
}
export const load = async ({ fetch }) => {
  const res = await fetch('http://localhost:8000/api/dogs');
  const dogs: Dog[] = await res.json();
  return { dogs };
};


