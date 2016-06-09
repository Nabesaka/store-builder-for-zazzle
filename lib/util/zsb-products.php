<?php if ( ! defined( 'ABSPATH' ) ) { die; } // Cannot access pages directly.

class Zsb_Products {

    /**
     * Array of Zsb_Product classes
     *
     * @var array
     */
    private $products;

    /**
     * Total number of results
     *
     * @var string
     */
    private $total;

    /**
     * Starting index
     *
     * @var string
     */
    private $start;

    /**
     * Number of items per page
     *
     * @var string
     */
    private $perPage;

    /**
     * The query (terms) used when getting XML feed
     *
     * @var string
     */
    private $query;

    /**
     * Flag for if an error occured
     *
     * @var boolean
     */
    private $error = false;

    public function __construct( $feed )
    {
        $this->create_products( $feed );
    }

    private function create_products( $feed )
    {
        $products = array();

        $xml = new SimpleXMLElement($feed);
        $xml->registerXPathNamespace('opensearch', 'http://a9.com/-/spec/opensearch/1.1/');
        $xml->registerXPathNamespace('media', 'http://search.yahoo.com/mrss/');

        foreach($xml->xpath('/rss/channel/item') as $item) {

          $product = new Zsb_Product();

          $product->setTitle($item->title);
          $product->setDesigner($item->author);
          $product->setPrice($item->price);
          $product->setDate($item->pubDate);
          $product->setLink($item->guid);
          $product->setDescription($item->xpath('media:description')[0]);
          $product->setDescriptionHTML($item->description);
          $product->setImageUrl($item->xpath('media:thumbnail')[0]->attributes()->url);
          $product->setRating($item->xpath('media:rating')[0]);
          $product->setKeywords($item->xpath('media:keywords')[0]);

          $products[] = $product;

        }

        $this->total = (string) $xml->xpath('/rss/channel/opensearch:totalResults')[0];
        $this->start = (string) $xml->xpath('/rss/channel/opensearch:startIndex')[0];
        $this->perPage = (string) $xml->xpath('/rss/channel/opensearch:itemsPerPage')[0];
        $this->query = (string) $xml->xpath('/rss/channel/opensearch:Query')[0];

        $this->products = $products;

        if( !is_array($this->products) || empty($this->products) ) {
            $this->error = true;
        }

    }


    /**
     * Get the value of Array of Zsb_Product classes
     *
     * @return array
     */
    public function getProducts()
    {
        return $this->products;
    }

    /**
     * Get the value of Total number of results
     *
     * @return string
     */
    public function getTotal()
    {
        return $this->total;
    }

    /**
     * Get the value of Starting index
     *
     * @return string
     */
    public function getStart()
    {
        return $this->start;
    }

    /**
     * Get the value of Number of items per page
     *
     * @return string
     */
    public function getPerPage()
    {
        return $this->perPage;
    }

    /**
     * Get the value of The query (terms) used when getting XML feed
     *
     * @return string
     */
    public function getQuery()
    {
        return $this->query;
    }

    /**
     * Get the value of Flag for if an error occured
     *
     * @return boolean
     */
    public function getError()
    {
        return $this->error;
    }

}
