<?php if ( ! defined( 'ABSPATH' ) ) { die; } // Cannot access pages directly.

class Zsb_Product {

    /**
     * Product Title
     *
     * @var string
     */
    private $title;

    /**
     * Product Author/Designer
     *
     * @var string
     */
    private $designer;

    /**
     * Product Price
     *
     * @var string
     */
    private $price;

    /**
     * Product Publish Date
     *
     * @var string
     */
    private $date;

    /**
     * Product GUID/Link
     *
     * @var string
     */
    private $link;

    /**
     * Product Description
     *
     * @var string
     */
    private $description;

    /**
     * Product Description with HTML
     *
     * @var string
     */
    private $descriptionHTML;

    /**
     * Product Image URL
     *
     * @var string
     */
    private $imageUrl;

    /**
     * Product Maturity Rating
     *
     * @var string
     */
    private $rating;

    /**
     * Product Keywords
     *
     * @var string
     */
    private $keywords;

    /**
     * Get the value of Product Title
     *
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set the value of Product Title
     *
     * @param string title
     *
     * @return self
     */
    public function setTitle($title)
    {
        $this->title = (string) $title;

        return $this;
    }

    /**
     * Get the value of Product Author/Designer
     *
     * @return string
     */
    public function getDesigner()
    {
        return $this->designer;
    }

    /**
     * Set the value of Product Author/Designer
     *
     * @param string designer
     *
     * @return self
     */
    public function setDesigner($designer)
    {
        $this->designer = (string) $designer;

        return $this;
    }

    /**
     * Get the value of Product Price
     *
     * @return string
     */
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * Set the value of Product Price
     *
     * @param string price
     *
     * @return self
     */
    public function setPrice($price)
    {
        $this->price = (string) $price;

        return $this;
    }

    /**
     * Get the value of Product Publish Date
     *
     * @return string
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * Set the value of Product Publish Date
     *
     * @param string date
     *
     * @return self
     */
    public function setDate($date)
    {
        $this->date = (string) $date;

        return $this;
    }

    /**
     * Get the value of Product GUID/Link
     *
     * @return string
     */
    public function getLink()
    {
        return $this->link;
    }

    /**
     * Set the value of Product GUID/Link
     *
     * @param string link
     *
     * @return self
     */
    public function setLink($link)
    {
        $this->link = (string) $link;

        return $this;
    }

    /**
     * Get the value of Product Description
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set the value of Product Description
     *
     * @param string description
     *
     * @return self
     */
    public function setDescription($description)
    {
        $this->description = (string) $description;

        return $this;
    }

    /**
     * Get the value of Product Description with HTML
     *
     * @return string
     */
    public function getDescriptionHTML()
    {
        return $this->descriptionHTML;
    }

    /**
     * Set the value of Product Description with HTML
     *
     * @param string descriptionHTML
     *
     * @return self
     */
    public function setDescriptionHTML($descriptionHTML)
    {
        $this->descriptionHTML = (string) $descriptionHTML;

        return $this;
    }

    /**
     * Get the value of Product Image URL
     *
     * @return string
     */
    public function getImageUrl()
    {
        return $this->imageUrl;
    }

    /**
     * Set the value of Product Image URL
     *
     * @param string imageUrl
     *
     * @return self
     */
    public function setImageUrl($imageUrl)
    {
        $this->imageUrl = (string) $imageUrl;

        return $this;
    }

    /**
     * Get the value of Product Maturity Rating
     *
     * @return string
     */
    public function getRating()
    {
        return $this->rating;
    }

    /**
     * Set the value of Product Maturity Rating
     *
     * @param string rating
     *
     * @return self
     */
    public function setRating($rating)
    {
        $this->rating = (string) $rating;

        return $this;
    }

    /**
     * Get the value of Product Keywords
     *
     * @return string
     */
    public function getKeywords()
    {
        return $this->keywords;
    }

    /**
     * Set the value of Product Keywords
     *
     * @param string keywords
     *
     * @return self
     */
    public function setKeywords($keywords)
    {
        $this->keywords = (string) $keywords;

        return $this;
    }

}
