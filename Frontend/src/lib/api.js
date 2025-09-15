export async function fetchDogs() {
    const response = await fetch('http://localhost:8001/api/dogs');

    if (!response.ok) {
        throw new Error('Erreur lors de la récupération des chiens');
    }

    return await response.json();
}
export async function fetchCats() {
    const response = await fetch('http://localhost:8001/api/cats');

    if (!response.ok) {
        throw new Error('Erreur lors de la récupération des chats');
    }

    return await response.json();
}
