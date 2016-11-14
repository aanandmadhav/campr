<?php

namespace AppBundle\Tests\Controller\Admin;

use AppBundle\Entity\WorkPackage;
use Symfony\Component\DomCrawler\Crawler;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class WorkPackageControllerTest extends BaseController
{
    public function testFormIsDisplayedOnCreatePage()
    {
        $this->user = $this->createUser('testuser', 'testuser@trisoft.ro', 'Password1', ['ROLE_SUPER_ADMIN']);
        $this->login($this->user);
        $this->assertNotNull($this->user, 'User not found');

        /** @var Crawler $crawler */
        $crawler = $this->client->request(Request::METHOD_GET, '/admin/workpackage/create');

        $this->assertContains('id="create_puid"', $crawler->html());
        $this->assertContains('name="create[puid]"', $crawler->html());
        $this->assertContains('id="create_name"', $crawler->html());
        $this->assertContains('name="create[name]"', $crawler->html());
        $this->assertContains('id="create_parent"', $crawler->html());
        $this->assertContains('name="create[parent]"', $crawler->html());
        $this->assertContains('id="create_colorStatus"', $crawler->html());
        $this->assertContains('name="create[colorStatus]"', $crawler->html());
        $this->assertContains('id="create_responsibility"', $crawler->html());
        $this->assertContains('name="create[responsibility]"', $crawler->html());
        $this->assertContains('id="create_scheduledStartAt"', $crawler->html());
        $this->assertContains('name="create[scheduledStartAt]"', $crawler->html());
        $this->assertContains('id="create_scheduledFinishAt"', $crawler->html());
        $this->assertContains('name="create[scheduledFinishAt]"', $crawler->html());
        $this->assertContains('id="create_content"', $crawler->html());
        $this->assertContains('name="create[content]"', $crawler->html());
        $this->assertContains('type="submit"', $crawler->html());

        $this->assertSame(Response::HTTP_OK, $this->client->getResponse()->getStatusCode());
    }

    public function testFormValidationOnCreatePage()
    {
        $this->user = $this->createUser('testuser', 'testuser@trisoft.ro', 'Password1', ['ROLE_SUPER_ADMIN']);
        $this->login($this->user);
        $this->assertNotNull($this->user, 'User not found');

        /** @var Crawler $crawler */
        $crawler = $this->client->request(Request::METHOD_GET, '/admin/workpackage/create');

        $form = $crawler->filter('#create-form')->first()->form();
        $crawler = $this->client->submit($form);

        $this->assertContains('PUID should not be blank', $crawler->html());
        $this->assertContains('The name field should not be blank', $crawler->html());

        $this->assertSame(Response::HTTP_OK, $this->client->getResponse()->getStatusCode());
    }

    public function testCreateAction()
    {
        $this->user = $this->createUser('testuser', 'testuser@trisoft.ro', 'Password1', ['ROLE_SUPER_ADMIN']);
        $this->login($this->user);
        $this->assertNotNull($this->user, 'User not found');

        $crawler = $this->client->request(Request::METHOD_GET, '/admin/workpackage/create');

        $form = $crawler->filter('#create-form')->first()->form();
        $form['create[puid]'] = 'puid3';
        $form['create[name]'] = 'workpackage3';

        $this->client->submit($form);
        $this->assertTrue($this->client->getResponse()->isRedirect());

        $this->client->followRedirect();
        $this->assertContains('WorkPackage successfully created!', $this->client->getResponse()->getContent());

        $workPackage = $this
            ->em
            ->getRepository(WorkPackage::class)
            ->findOneBy([
                'puid' => 'puid3',
            ])
        ;
        $this->em->remove($workPackage);
        $this->em->flush();
    }

    public function testDeleteAction()
    {
        $this->user = $this->createUser('testuser', 'testuser@trisoft.ro', 'Password1', ['ROLE_SUPER_ADMIN']);
        $this->login($this->user);
        $this->assertNotNull($this->user, 'User not found');

        $workPackage = (new WorkPackage())
            ->setPuid('puid4')
            ->setName('workpackage4')
        ;
        $this->em->persist($workPackage);
        $this->em->flush();

        $crawler = $this->client->request(Request::METHOD_GET, sprintf('/admin/workpackage/%d/edit', $workPackage->getId()));

        $link = $crawler->selectLink('Delete')->link();
        $this->client->click($link);
        $this->assertTrue($this->client->getResponse()->isRedirect());

        $this->client->followRedirect();
        $this->assertContains('WorkPackage successfully deleted!', $this->client->getResponse()->getContent());
    }

    public function testFormIsDisplayedOnEditPage()
    {
        $this->user = $this->createUser('testuser', 'testuser@trisoft.ro', 'Password1', ['ROLE_SUPER_ADMIN']);
        $this->login($this->user);
        $this->assertNotNull($this->user, 'User not found');

        /** @var Crawler $crawler */
        $crawler = $this->client->request(Request::METHOD_GET, '/admin/workpackage/1/edit');

        $this->assertContains('id="create_puid"', $crawler->html());
        $this->assertContains('name="create[puid]"', $crawler->html());
        $this->assertContains('id="create_name"', $crawler->html());
        $this->assertContains('name="create[name]"', $crawler->html());
        $this->assertContains('id="create_parent"', $crawler->html());
        $this->assertContains('name="create[parent]"', $crawler->html());
        $this->assertContains('id="create_colorStatus"', $crawler->html());
        $this->assertContains('name="create[colorStatus]"', $crawler->html());
        $this->assertContains('id="create_responsibility"', $crawler->html());
        $this->assertContains('name="create[responsibility]"', $crawler->html());
        $this->assertContains('id="create_scheduledStartAt"', $crawler->html());
        $this->assertContains('name="create[scheduledStartAt]"', $crawler->html());
        $this->assertContains('id="create_scheduledFinishAt"', $crawler->html());
        $this->assertContains('name="create[scheduledFinishAt]"', $crawler->html());
        $this->assertContains('id="create_content"', $crawler->html());
        $this->assertContains('name="create[content]"', $crawler->html());
        $this->assertContains('type="submit"', $crawler->html());
        $this->assertContains('class="zmdi zmdi-delete"', $crawler->html());

        $this->assertSame(Response::HTTP_OK, $this->client->getResponse()->getStatusCode());
    }

    public function testFormValidationOnEditPage()
    {
        $this->user = $this->createUser('testuser', 'testuser@trisoft.ro', 'Password1', ['ROLE_SUPER_ADMIN']);
        $this->login($this->user);
        $this->assertNotNull($this->user, 'User not found');

        /** @var Crawler $crawler */
        $crawler = $this->client->request(Request::METHOD_GET, '/admin/workpackage/1/edit');

        $form = $crawler->filter('#edit-form')->first()->form();
        $form['create[puid]'] = '';
        $form['create[name]'] = '';

        $crawler = $this->client->submit($form);

        $this->assertContains('PUID should not be blank', $crawler->html());
        $this->assertContains('The name field should not be blank', $crawler->html());

        $this->assertSame(Response::HTTP_OK, $this->client->getResponse()->getStatusCode());
    }

    public function testEditAction()
    {
        $this->user = $this->createUser('testuser', 'testuser@trisoft.ro', 'Password1', ['ROLE_SUPER_ADMIN']);
        $this->login($this->user);
        $this->assertNotNull($this->user, 'User not found');

        $crawler = $this->client->request(Request::METHOD_GET, '/admin/workpackage/2/edit');

        $form = $crawler->filter('#edit-form')->first()->form();
        $form['create[name]'] = 'workpackage2';

        $this->client->submit($form);
        $this->assertTrue($this->client->getResponse()->isRedirect());

        $this->client->followRedirect();
        $this->assertContains('WorkPackage successfully edited!', $this->client->getResponse()->getContent());
    }

    public function testDataTableOnListPage()
    {
        $this->user = $this->createUser('testuser', 'testuser@trisoft.ro', 'Password1', ['ROLE_SUPER_ADMIN']);
        $this->login($this->user);
        $this->assertNotNull($this->user, 'User not found');

        /** @var Crawler $crawler */
        $crawler = $this->client->request(Request::METHOD_GET, '/admin/workpackage/list');

        $this->assertEquals(1, $crawler->filter('#data-table-command')->count());
        $this->assertContains('data-column-id="id"', $crawler->html());
        $this->assertContains('data-column-id="puid"', $crawler->html());
        $this->assertContains('data-column-id="name"', $crawler->html());
        $this->assertContains('data-column-id="responsibility"', $crawler->html());
        $this->assertContains('data-column-id="scheduledStartAt"', $crawler->html());
        $this->assertContains('data-column-id="scheduledFinishAt"', $crawler->html());
        $this->assertContains('data-column-id="commands"', $crawler->html());
        $this->assertEquals(1, $crawler->filter('.zmdi-plus')->count());

        $this->assertSame(Response::HTTP_OK, $this->client->getResponse()->getStatusCode());
    }

    public function testTableStructureOnShowAction()
    {
        $this->user = $this->createUser('testuser', 'testuser@trisoft.ro', 'Password1', ['ROLE_SUPER_ADMIN']);
        $this->login($this->user);
        $this->assertNotNull($this->user, 'User not found');

        /** @var Crawler $crawler */
        $crawler = $this->client->request(Request::METHOD_GET, '/admin/workpackage/1/show');

        $this->assertEquals(1, $crawler->filter('.dropdown-menu-right')->count());
        $this->assertEquals(1, $crawler->filter('.table-responsive')->count());
        $this->assertEquals(1, $crawler->filter('.table-striped')->count());

        $this->assertSame(Response::HTTP_OK, $this->client->getResponse()->getStatusCode());
    }
}