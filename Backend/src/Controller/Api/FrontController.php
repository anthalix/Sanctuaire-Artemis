<?php

namespace App\Controller\Api;

use App\Entity\User;
use App\Entity\Message;
use App\Entity\FrontUser;
use App\Service\RoleManager;
use App\Security\EmailVerifier;
use Symfony\Component\Mime\Address;
use App\Repository\FrontUserRepository;
;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Security\Http\Attribute\IsGranted;

use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Lexik\Bundle\JWTAuthenticationBundle\Services\JWTTokenManagerInterface;
use SymfonyCasts\Bundle\VerifyEmail\Exception\VerifyEmailExceptionInterface;


final class FrontController extends AbstractController

{

#[Route('/api/register', name: 'api_register', methods: ['POST'])]
public function apiRegister(
    Request $request,
    UserPasswordHasherInterface $passwordHasher,
    EmailVerifier $emailVerifier,
    EntityManagerInterface $entityManager
): JsonResponse {
    $data = json_decode($request->getContent(), true);

    $username = $data['username'] ?? null;
    $email = $data['email'] ?? null;
    $tel = $data['tel'] ?? null;
    $adresse= $data['adresse'] ?? null;
    $password = $data['password'] ?? null;

    if (!$email || !$password || !$username) {
        return new JsonResponse(['error' => 'Paramètres manquants'], 400);
    }

    if ($entityManager->getRepository(FrontUser::class)->findOneBy(['email' => $email])) {
        return new JsonResponse(['error' => 'Email déjà utilisé'], 400);
    }

    $FrontUser = new FrontUser();
    $FrontUser->setEmail($email);
    $FrontUser->setUsername($username);
    $FrontUser->setTel($tel);
    $FrontUser->setAdresse($adresse);
    $FrontUser->setPassword($passwordHasher->hashPassword($FrontUser, $password));

    $entityManager->persist($FrontUser);
    $entityManager->flush();

    // Envoi de l’email de confirmation (Symfony gère le signedUrl automatiquement)
    $emailVerifier->sendEmailConfirmation(
        'api_verify_email', // nom de la route qui gère la vérification
        $FrontUser,
        (new TemplatedEmail())
            ->from(new Address('support@io.fr', 'Support'))
            ->to($FrontUser->getEmail())
            ->subject('Confirmez votre email')
            ->htmlTemplate('registration/confirmation_email_svelte.html.twig')
            ->context([
                'FrontUser' => $FrontUser,
            ])
    );

    return new JsonResponse([
        'message' => 'Utilisateur créé. Veuillez vérifier votre email.'
    ]);
}


#[Route('/api/verify-email', name: 'api_verify_email', methods: ['GET'])]
public function apiVerifyEmail(
    Request $request,
    EntityManagerInterface $em,
    EmailVerifier $emailVerifier,
    RoleManager $roleManager
): Response {
    // Récupère l'ID dans l'URL
    $id = $request->query->get('id');

    if (!$id) {
        // Redirige vers page d'erreur front si pas d'ID
        return $this->redirect('http://localhost:5173/verify-email-error');
    }

    // Cherche l'utilisateur dans les deux entités possibles
    $user = $em->getRepository(FrontUser::class)->find($id)
        ?? $em->getRepository(User::class)->find($id);

    if (!$user) {
        return $this->redirect('http://localhost:5173/verify-email-error');
    }

    try {
        // Confirme l'email
        $emailVerifier->handleEmailConfirmation($request, $user);

        // Assigne les rôles correctement
        $roleManager->assignRolesOnVerification($user);

        // Persist et flush pour sauvegarder isVerified + rôles
        $em->persist($user);
        $em->flush();

        // Redirection vers le front avec l’ID utilisateur
        return $this->redirect('http://localhost:5173/verify-email-success/' . $user->getId());
    } catch (VerifyEmailExceptionInterface $e) {
        // Lien invalide ou expiré
        return $this->redirect('http://localhost:5173/verify-email-error');
    } catch (\Throwable $e) {
        // Erreur serveur
        // Tu peux logger $e->getMessage() ici si besoin
        return $this->redirect('http://localhost:5173/verify-email-error');
    }
}


   
    #[Route('/api/login', name: 'api_login', methods: ['POST'])]
    public function apiLogin(Request $request, UserPasswordHasherInterface $passwordHasher,FrontUserRepository $frontuserRepository,JWTTokenManagerInterface $jwtManager): JsonResponse
    {
        $data = json_decode($request->getContent(), true);
        $email = $data['email'] ?? null;
        $password = $data['password'] ?? null;
        $user = $frontuserRepository->findOneBy(['email' => $email]);

        if (!$user || !$passwordHasher->isPasswordValid($user, $data['password'])) {
            return $this->json(['success' => false, 'message' => 'Invalid credentials'], 401);
        }

        // Stocker l'ID utilisateur en session
        $session = $request->getSession();
        $session->set('user_id', $user->getId());

        $token = $jwtManager->create($user);

        return $this->json([
            'token' => $token,
            'user' => [
                'id' => $user->getId(),
                'email' => $user->getEmail(),
                'username' => $user->getUsername(),
                'tel'=>$user->getTel(),
                'adresse'=>$user->getAdresse()

            ]
        ]);
    }

    #[Route('/api/message', name: 'api_message', methods: ['POST'])]
    public function create(
    Request $request,
    EntityManagerInterface $em,
    FrontUserRepository $userRepo
    ): JsonResponse {
        $data = json_decode($request->getContent(), true);
        // Vérifie que userId et message sont présents
        if (!isset($data['userId'], $data['message'])) {
            return new JsonResponse(['error' => 'Champs manquants'], 400);
        }

        $user = $userRepo->find($data['userId']);
        if (!$user) {
            return new JsonResponse(['error' => 'Utilisateur introuvable'], 404);
        }

        // Création du message
        $messageEntity = new Message();
        $messageEntity->setContent($data['message']);

        $messageEntity->getUsers()->add($user); // si ManyToMany avec contact_message

        $em->persist($messageEntity);
        $em->flush();

        return new JsonResponse([
            'status' => 'Message enregistré',
            'id' => $messageEntity->getId()
        ], 201);
    }
    #[Route('/api/front-user/{id}', name: 'api_front_user', methods: ['GET'])]
public function getFrontUser(FrontUser $user): JsonResponse {
    return $this->json([
        'id' => $user->getId(),
        'username' => $user->getUsername(),
        'email' => $user->getEmail(),
        'roles' => $user->getRoles(),
    ]);
}



}