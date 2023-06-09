<?php

namespace App\Controller;

use App\Entity\Course;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;
use App\Repository\CourseRepository;
use App\Repository\UserRepository;

class CourseController extends AbstractController
{

    #[Route('/course', name: 'app_course')]
    public function index(): JsonResponse
    {
        return $this->json([
            'message' => 'Welcome to your new controller!',
            'path' => 'src/Controller/CourseController.php',
        ]);
    }

    #[Route('/course-list', name: 'course-list', methods: ['GET'])]
    public function getCourseList(CourseRepository $courseRepository, SerializerInterface $serializer): JsonResponse
    {
        $coursesList = $courseRepository->findAll();

        $serializedCourses = $serializer->serialize($coursesList, 'json', ['groups' => ['course','course_users', 'course_professor', 'course_composers']]);

        return new JsonResponse($serializedCourses, 200, [], true);

    }

    #[Route('/course-list-by-user/{userId}', name: 'course-list-by-user', methods: ['GET'])]
    public function getCourseListByUser(int $userId, CourseRepository $courseRepository, UserRepository $userRepository, SerializerInterface $serializer): JsonResponse
    {
        $user = $userRepository->find($userId);

        if (!$user) {
            return new JsonResponse(['message' => 'User not found'], 404);
        }

        $courses = $courseRepository->findByUser($user);

        $serializedCourses = $serializer->serialize($courses, 'json', ['groups' => ['course','course_users', 'course_professor', 'course_composers']]);

        return new JsonResponse($serializedCourses, 200, [], true);

    }
}
