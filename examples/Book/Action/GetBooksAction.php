<?php
declare(strict_types=1);

namespace WoohooLabs\Yin\Examples\Book\Action;

use Psr\Http\Message\ResponseInterface;
use WoohooLabs\Yin\Examples\Book\JsonApi\Document\BooksDocument;
use WoohooLabs\Yin\Examples\Book\JsonApi\Resource\AuthorResourceTransformer;
use WoohooLabs\Yin\Examples\Book\JsonApi\Resource\BookResourceTransformer;
use WoohooLabs\Yin\Examples\Book\JsonApi\Resource\PublisherResourceTransformer;
use WoohooLabs\Yin\Examples\Book\JsonApi\Resource\RepresentativeResourceTransformer;
use WoohooLabs\Yin\Examples\Book\Repository\BookRepository;
use WoohooLabs\Yin\JsonApi\JsonApi;

class GetBooksAction
{
    public function __invoke(JsonApi $jsonApi): ResponseInterface
    {
        // Extracting pagination information from the request, page = 1, size = 10 if it is missing
        $pagination = $jsonApi->getRequest()->getPageBasedPagination(1, 10);

        // Retrieving a paginated collection of Book domain objects
        $books = BookRepository::getBooks($pagination->getPage(), $pagination->getSize());

        // Instantiating a Books document
        $document = new BooksDocument(
            new BookResourceTransformer(
                new AuthorResourceTransformer(),
                new PublisherResourceTransformer(
                    new RepresentativeResourceTransformer()
                )
            )
        );

        // Responding with "200 Ok" status code along with the Books document
        return $jsonApi->respond()->ok($document, $books);
    }
}
