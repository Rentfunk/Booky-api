<?php

namespace App\DataFixtures;

use App\Entity\ClassHasBook;
use App\Entity\SchoolYear;
use App\Entity\TeacherHasBook;
use App\Factory\BookFactory;
use App\Factory\ClassroomFactory;
use App\Factory\GradeFactory;
use App\Factory\OrderFactory;
use App\Factory\TagFactory;
use App\Factory\TeacherFactory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        foreach (range(5,9) as $grade) {
            $newGrade = GradeFactory::createOne(["name" => (string) $grade]);
            $characters = "ABC";
            for ($i = 0; $i < rand(1, 3); $i++) {
                ClassroomFactory::createOne([
                    "name" => $grade.".".$characters[$i],
                    "grade" => $newGrade
                ]);
            }
        }

        BookFactory::createMany(20, fn () => ["grades" => GradeFactory::randomSet(rand(1,3))]);

        $newSchoolYear = new SchoolYear();
        $newSchoolYear->setYear("2020/2021");
        $newSchoolYear->setIsCurrent(true);

        $manager->persist($newSchoolYear);

        foreach(ClassroomFactory::all() as $classroom) {
            foreach (BookFactory::all() as $book) {
                if (rand(1,5) % 2 == 0) {
                    $classHasBook = new ClassHasBook();
                    $classHasBook->setClassroom($classroom->object());
                    $classHasBook->setBook($book->object());
                    $classHasBook->setSchoolYear($newSchoolYear);
                    $classHasBook->setBooksOwned(mt_rand(8, 10));
                    $classHasBook->setBooksReturned(mt_rand(5, 8));
                    $manager->persist($classHasBook);
                }
            }
        }

        TeacherFactory::createMany(10);

        foreach(TeacherFactory::all() as $teacher) {
            foreach(BookFactory::all() as $book) {
                if (rand(1, 5) % 2 == 0) {
                    $teacherHasBook = new TeacherHasBook();
                    $teacherHasBook->setTeacher($teacher->object());
                    $teacherHasBook->setBook($book->object());
                    $teacherHasBook->setSchoolYear($newSchoolYear);
                    $teacherHasBook->setBooksOwned(mt_rand(8, 10));
                    $teacherHasBook->setBooksReturned(mt_rand(5, 8));
                    $manager->persist($teacherHasBook);
                }
            }
        }

        TagFactory::createMany(20);

        OrderFactory::createMany(30);


        $manager->flush();
    }
}
