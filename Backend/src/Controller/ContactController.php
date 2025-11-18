<?php

namespace App\Controller;

use App\Entity\User;
use App\DTO\ContactDTO;
use App\Entity\FrontUser;
use App\Form\ContactTypeForm;
use App\Repository\MessagesRepository;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


final class ContactController extends AbstractController
{
    #[IsGranted('ROLE_USER')]
    #[Route('/contact', name: 'contact')]
    public function index(Request $request, MailerInterface $mailer): Response
    {
        /** @var User $user */
        $user = $this->getUser();

        $data = new ContactDTO(
            name: $user->getUsername(),
            email: $user->getEmail()
        );



        $form = $this->createForm(ContactTypeForm::class, $data);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            try {

                $mail = (new TemplatedEmail())
                    ->to('contact@athena.io')
                    ->from($data->email)
                    ->subject('Demande de contact')
                    ->htmlTemplate('emails/contact.html.twig')
                    ->context(['data' => $data]);
                $mailer->send($mail);

                $this->addFlash('success', ' Votre email a été envoyé');
                return $this->redirectToRoute('home');
            } catch (\Exception $e) {
                dd($e->getMessage());
                $this->addFlash('danger', 'Une erreur est survenue lors de l\'envoi de votre message.');
                return $this->redirectToRoute('contact');
            }
        }
        return $this->render('contact/index.html.twig', [
            'form' => $form,
        ]);
    }
    #[IsGranted('ROLE_ADMIN')]
    #[Route('/messages/{id}', name: 'messages')]
    public function messages(FrontUser $user, MessagesRepository $contactMessage): Response
    {
        $messages = $contactMessage->findMessagesForUser($user);
        return $this->render('admin/messages/list.html.twig', [
            'messages' => $messages,
            'user' => $user
        ]);
    }
}
