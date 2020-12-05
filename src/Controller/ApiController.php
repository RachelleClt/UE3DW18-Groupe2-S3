<?php

namespace Watson\Controller;

use Silex\Application;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Watson\Domain\Link;

class ApiController {

    /**
     * API links controller.
     *
     * @param Application $app Silex application
     *
     * @return All links in JSON format
     */
    public function getLinksAction(Application $app) {
        $links = $app['dao.link']->findAll();
        // Convert an array of objects ($links) into an array of associative arrays ($responseData)
        $responseData = array();
        foreach ($links as $link) {
            $responseData[] = $this->buildLinkArray($link);
        }
        // Create and return a JSON response
        return $app->json($responseData);
    }

    /**
     * API link details controller.
     *
     * @param integer $id Link id
     * @param Application $app Silex application
     *
     * @return Link details in JSON format
     */
    public function getLinkAction($id, Application $app) {
        $link = $app['dao.link']->find($id);
        $responseData = $this->buildLinkArray($link);
        // Create and return a JSON response
        return $app->json($responseData);
    }

    /**
     * API create link controller.
     *
     * @param Request $request Incoming request
     * @param Application $app Silex application
     *
     * @return Link details in JSON format
     */
    public function addLinkAction(Request $request, Application $app) {
        // Check request parameters
        if (!$request->request->has('lien_titre')) {
            return $app->json('Missing required parameter: lien_titre', 400);
        }
        if (!$request->request->has('lien_url')) {
            return $app->json('Missing required parameter: lien_url', 400);
        }
        if (!$request->request->has('lien_desc')) {
            return $app->json('Missing required parameter: lien_desc', 400);
        }

        // Build and save the new link
        $link = new Link();
        $link->setTitle($request->request->get('lien_titre'));
        $link->setUrl($request->request->get('lien_url'));
        if (!$request->request->has('lien_desc')) {
            $link->setDesc($request->request->get('lien_desc'));
        }
        $app['dao.link']->save($link);
        $responseData = $this->buildLinkArray($link);
        return $app->json($responseData, 201);  // 201 = Created
    }

    /**
     * API delete link controller.
     *
     * @param integer $id Link id
     * @param Application $app Silex application
     */
    public function deleteLinkAction($id, Application $app) {
        // Delete the link
        $app['dao.link']->delete($id);
        return $app->json('No Content', 204);  // 204 = No content
    }

    /**
     * Converts an Link object into an associative array for JSON encoding
     *
     * @param Link $link Link object
     *
     * @return array Associative array whose fields are the link properties.
     */
    private function buildLinkArray(Link $link) {
        $data  = array(
            'id' => $link->getId(),
            'lien_titre' => $link->getTitle(),
            'lien_url' => $link->getUrl(),
            'lien_desc' => $link->getDesc(),
        );
        return $data;
    }

    /**
     * Send an XML File of the RSS feed from the last 15 links added
     * 
     * @param Application $app Silex application
     * 
     * @return array Associative array whose fields are the link properties.
     *
     */
    private function getFeed(Application $app) {
        $links = $app['dao.link']->findFifteen();
        $myfile = fopen("rss.xml", "w");
        $xmlFile = "<?xml version=\"1.0\" encoding=\"UTF-8\"?>
        <rss version=\"2.0\"><channel><title>15 Derniers Liens</title>
        <description>Les 15 dernieres liens ajoutés sur le site de Watson</description>
        <link>https://www.watson.com</link>";
        foreach($links as $link){
            $xmlFile += "<item><title>".$link->getTitle()."</title>
            <description>".$link->getDesc()."</description>
            <link>".$link->getUrl()."</link>
            <author>".$link->getUser()."</author>";
        }
        $xmlFile += "</channel></rss>";
        file_put_contents("rss.xml", $xmlFile);
        return $myfile;
    }
}
