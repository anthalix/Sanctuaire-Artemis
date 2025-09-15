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
  status:string;
  taille:string;
}
export const load = async ({ fetch }) => {
  const res = await fetch('http://localhost:8000/api/cats');
  const cats: Cat[] = await res.json();
  return { cats};
};


