<?php
namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;

use Knp\Snappy\Pdf;
use Knp\Bundle\SnappyBundle\Snappy\Response\PdfResponse;

use App\Entity\User;
use App\Form\UserType;
use App\Entity\Network;
use App\Form\NetworksType;
use App\Entity\Experience;
use App\Form\ExperienceType;
use App\Entity\Diplome;
use App\Form\DiplomeType;
use App\Entity\Competence;
use App\Form\CompetenceType;
use App\Entity\CV;
use App\Form\UserManageType;


class CVController extends AbstractController{

    /**
     * @var EntityManagerInterface
     */
    private $em;

    public function __construct(EntityManagerInterface $em){
        $this->em = $em;
    }

    /**
     * @Route("/cv", name="app_cv")
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function index():Response{
        if($user = $this->getUser()){

            $cvs = $user->getUserCvs();

            return $this->render('cv/index.html.twig',[
                'cvs' => $cvs
            ]);
        }else{
            return $this->redirectToRoute('app_login');
        }
    }

    /**
     * @Route("/cv/create", name="cv.create")
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function create(Request $request, ValidatorInterface $validator):Response{

        if($user = $this->getUser()){
            $formUser = $this->createForm(UserType::class, $user);
            $formUser->handleRequest($request);
            $errorsUser = $validator->validate($user);

            if($formUser->isSubmitted() && $formUser->isValid()){
                //on valide les données du form avant de les envoyer
                if(count($errorsUser) == 0){
                    //flush query + return success message
                    $this->em->persist($user);
                    $this->em->flush();
                    // $this->addFlash('success', 'Création faite avec succès');
                    // return $this->redirectToRoute('cv.edit');

                    if($formUser->get('saveAndManage')->isClicked()){
                        return $this->redirectToRoute('cv.manage');
                    }
                }
            }

            return $this->render('cv/create.html.twig', [
                'formUser' => $formUser->createView(),
                'errorsUser' => $errorsUser ?? null
            ]);
        }else{
            return $this->redirectToRoute('app_login');
        }
    }

     /**
     * @Route("/cv/manage", name="cv.manage")
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function manage(Request $request, ValidatorInterface $validator):Response{
        if($user = $this->getUser()){
            $formUser = $this->createForm(UserManageType::class, $user, ['user' => $user]);
            $formUser->handleRequest($request);
            $errorsUser = $validator->validate($user);
        
            if($formUser->isSubmitted() && $formUser->isValid()){
                //on valide les données du form avant de les envoyer
                if(count($errorsUser) == 0){
                    $networks = $formUser->get('networks')->getData();
                    $experiences = $formUser->get('experiences')->getData();
                    $diplomes = $formUser->get('diplomes')->getData();
                    $competences = $formUser->get('competences')->getData();

                    $cv = new CV();
                    $cv->setCvUser($user);
                    foreach ($networks as $network) {
                        if(!empty($network)){
                            $cv->addCvNetwork($network);
                        }
                    }

                    foreach ($experiences as $experience) {
                        if(!empty($experience)){
                            $cv->addCvExperience($experience);
                        }
                    }

                    foreach ($diplomes as $diplome) {
                        if(!empty($diplome)){
                            $cv->addCvDiplome($diplome);
                        }
                    }

                    foreach ($competences as $competence) {
                        if(!empty($competence)){
                            $cv->addCvCompetence($competence);
                        }
                    }

                    //flush query
                    $this->em->persist($cv);
                    $this->em->flush();

                   return $this->redirectToRoute('cv.generate', ['id' => $cv->getId()]);
                }
            }

            return $this->render('cv/manage.html.twig', [
                'formUser' => $formUser->createView(),
                'errorsUser' => $errorsUser ?? null
            ]);
        }else{
            return $this->redirectToRoute('app_login');
        }
    }

    /**
     * @Route("/cv/{id}/generate", name="cv.generate")
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function generate(CV $cv, Request $request, ValidatorInterface $validator):Response{
        if($user = $this->getUser()){

            return $this->render('cv/generate.html.twig', [
                'cv' => $cv
            ]);
        }else{
            return $this->redirectToRoute('app_login');
        }
    }


     /**
     * @Route("/cv/edit", name="cv.edit")
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function edit(Request $request, ValidatorInterface $validator):Response{


        return $this->render('cv/edit.html.twig');
    }
}