<script lang="ts">
    import { onMount } from 'svelte';

    let user: { id: number; username: string; email: string; roles: string[]; tel: string; adresse: string } | null = null;
    let tel = "";
    let adresse = "";
    let success = "";
    let error = "";
    let message = "";

    onMount(() => {
        const storedUser = localStorage.getItem('user');
        if (storedUser) {
            user = JSON.parse(storedUser);

        } else {
            window.location.href = "/login";
        }

    })

    async function sendMessage() {
        if (!user) {
            error = "Utilisateur non trouvé";
            return;
        }
        try {
            const response = await fetch("http://localhost:8000/api/message", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    "Authorization": `Bearer ${localStorage.getItem("token")}` // si tu utilises JWT
                },
                body: JSON.stringify({
                    userId: user.id,
                    message: message
                })
            });

            if (!response.ok) {
                throw new Error("Erreur lors de l’envoi du message");
            }

            success = "Message envoyé avec succès";
            message = ""; // reset du champ
              setTimeout(() => {
        success = "";
      }, 3000);

        } catch (error) {
            console.error(error);
            error = "Message non envoyé";

        }
    }

</script>

<div class="container_register">
    <div class="select_register">
        <h2>Nous contacter</h2>
        <form on:submit|preventDefault={sendMessage} class="flex flex-col gap-3">
            <div class="form">


            <input type="text" value={user?.username} readonly class="border p-2 rounded  " />
            <input type="email" value={user?.email} readonly class="border p-2 rounded" />


            <input type="tel" value={user?.tel}  class="border p-2 rounded" />
            </div>

            <input type="text" value={user?.adresse}  class="border p-2 rounded" />
            <textarea bind:value={message} placeholder="Votre message" rows="5" class="border p-2 rounded w-full">
            </textarea>


            <button type="submit" class="btn btn-primary text-white p-1 rounded">Envoyer</button>
        </form>

        {#if success}<p class="success">{success}</p>{/if}
        {#if error}<p class="error">{error}</p>{/if}
    </div>
</div>
<style>

 .form{
     display: flex;
     flex-direction:row;
     gap: 1rem;
     width: 100%;
 }
 .form input{
     width: 175px;
     padding-left:15px;
     font-size: 0.8rem;
 }
 p.success{
     color: rgb(34, 98, 34);
     background-color: greenyellow;
     margin-top: 2rem;
 }
 p.error{
     color: red;
     background-color: rgb(248, 99, 99);
     margin-top: 2rem;
 }


</style>