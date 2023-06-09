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

    #[Route('/courses', name: 'course-list', methods: ['GET'])]
    public function getCourseList(CourseRepository $courseRepository, SerializerInterface $serializer): JsonResponse
    {
        $coursesList = $courseRepository->findAll();

        $serializedCourses = $serializer->serialize($coursesList, 'json', ['groups' => ['course','course_users', 'course_professor', 'course_composers']]);

        return new JsonResponse($serializedCourses, 200, [], true);

    }

    #[Route('/courses/users/{userId}', name: 'course-list-by-user', methods: ['GET'])]
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

    #[Route('/courses/professors/{profId}', name: 'course-list-by-prof', methods: ['GET'])]
    public function getCourseListByProf(int $profId, CourseRepository $courseRepository, UserRepository $userRepository, SerializerInterface $serializer): JsonResponse
    {
        $user = $userRepository->find($profId);

        if (!$user) {
            return new JsonResponse(['message' => 'Professor not found'], 404);
        }

        $courses = $courseRepository->findByProf($user);

        $serializedCourses = $serializer->serialize($courses, 'json', ['groups' => ['course','course_users', 'course_professor', 'course_composers']]);

        return new JsonResponse($serializedCourses, 200, [], true);

    }

    #[Route('/courses/instruments/{instrumentId}', name: 'course-list-by-instrument', methods: ['GET'])]
    public function getCourseListByInstrument(int $instrumentId, CourseRepository $courseRepository, UserRepository $userRepository, SerializerInterface $serializer): JsonResponse
    {
        $user = $userRepository->find($instrumentId);

        if (!$user) {
            return new JsonResponse(['message' => 'Instrument not found'], 404);
        }

        $courses = $courseRepository->findByInstrument($user);

        $serializedCourses = $serializer->serialize($courses, 'json', ['groups' => ['course','course_users', 'course_professor', 'course_composers']]);

        return new JsonResponse($serializedCourses, 200, [], true);

    }
}
