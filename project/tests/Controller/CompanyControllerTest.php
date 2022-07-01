<?php

namespace App\Test\Controller;

use App\Entity\Company;
use App\Repository\CompanyRepository;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class CompanyControllerTest extends WebTestCase
{
    private KernelBrowser $client;
    private CompanyRepository $repository;
    private string $path = '/company/crud/';

    protected function setUp(): void
    {
        $this->client = static::createClient();
        $this->repository = (static::getContainer()->get('doctrine'))->getRepository(Company::class);

        foreach ($this->repository->findAll() as $object) {
            $this->repository->remove($object, true);
        }
    }

    public function testIndex(): void
    {
        $crawler = $this->client->request('GET', $this->path);

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('Company index');

        // Use the $crawler to perform additional assertions e.g.
        // self::assertSame('Some text on the page', $crawler->filter('.p')->first());
    }

    public function testNew(): void
    {
        $originalNumObjectsInRepository = count($this->repository->findAll());

        $this->markTestIncomplete();
        $this->client->request('GET', sprintf('%snew', $this->path));

        self::assertResponseStatusCodeSame(200);

        $this->client->submitForm('Save', [
            'company[name]' => 'Testing',
            'company[siren]' => 'Testing',
            'company[activityArea]' => 'Testing',
            'company[address]' => 'Testing',
            'company[zipCode]' => 'Testing',
            'company[city]' => 'Testing',
            'company[country]' => 'Testing',
            'company[phoneNumber]' => 'Testing',
        ]);

        self::assertResponseRedirects('/company/crud/');

        self::assertSame($originalNumObjectsInRepository + 1, count($this->repository->findAll()));
    }

    public function testShow(): void
    {
        $this->markTestIncomplete();
        $fixture = new Company();
        $fixture->setName('My Title');
        $fixture->setSiren('My Title');
        $fixture->setActivityArea('My Title');
        $fixture->setAddress('My Title');
        $fixture->setZipCode('My Title');
        $fixture->setCity('My Title');
        $fixture->setCountry('My Title');
        $fixture->setPhoneNumber('My Title');

        $this->repository->add($fixture, true);

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('Company');

        // Use assertions to check that the properties are properly displayed.
    }

    public function testEdit(): void
    {
        $this->markTestIncomplete();
        $fixture = new Company();
        $fixture->setName('My Title');
        $fixture->setSiren('My Title');
        $fixture->setActivityArea('My Title');
        $fixture->setAddress('My Title');
        $fixture->setZipCode('My Title');
        $fixture->setCity('My Title');
        $fixture->setCountry('My Title');
        $fixture->setPhoneNumber('My Title');

        $this->repository->add($fixture, true);

        $this->client->request('GET', sprintf('%s%s/edit', $this->path, $fixture->getId()));

        $this->client->submitForm('Update', [
            'company[name]' => 'Something New',
            'company[siren]' => 'Something New',
            'company[activityArea]' => 'Something New',
            'company[address]' => 'Something New',
            'company[zipCode]' => 'Something New',
            'company[city]' => 'Something New',
            'company[country]' => 'Something New',
            'company[phoneNumber]' => 'Something New',
        ]);

        self::assertResponseRedirects('/company/crud/');

        $fixture = $this->repository->findAll();

        self::assertSame('Something New', $fixture[0]->getName());
        self::assertSame('Something New', $fixture[0]->getSiren());
        self::assertSame('Something New', $fixture[0]->getActivityArea());
        self::assertSame('Something New', $fixture[0]->getAddress());
        self::assertSame('Something New', $fixture[0]->getZipCode());
        self::assertSame('Something New', $fixture[0]->getCity());
        self::assertSame('Something New', $fixture[0]->getCountry());
        self::assertSame('Something New', $fixture[0]->getPhoneNumber());
    }

    public function testRemove(): void
    {
        $this->markTestIncomplete();

        $originalNumObjectsInRepository = count($this->repository->findAll());

        $fixture = new Company();
        $fixture->setName('My Title');
        $fixture->setSiren('My Title');
        $fixture->setActivityArea('My Title');
        $fixture->setAddress('My Title');
        $fixture->setZipCode('My Title');
        $fixture->setCity('My Title');
        $fixture->setCountry('My Title');
        $fixture->setPhoneNumber('My Title');

        $this->repository->add($fixture, true);

        self::assertSame($originalNumObjectsInRepository + 1, count($this->repository->findAll()));

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));
        $this->client->submitForm('Delete');

        self::assertSame($originalNumObjectsInRepository, count($this->repository->findAll()));
        self::assertResponseRedirects('/company/crud/');
    }
}
