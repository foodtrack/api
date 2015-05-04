<?php
namespace Foodtrack\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @Entity
 */
class Food
{
    /**
     * @Id
     * @Column(type="string", unique=true, nullable=false)
     */
    protected $name;

    /**
     * @Column(type="integer", nullable=false, options={"unsigned":true})
     */
    protected $calories;

    public function setName($name)
    {
        $this->name = $name;
        return $this;
    }

    public function getName()
    {
        return $this->name;
    }

    public function setCalories($calories)
    {
        $this->calories = $calories;
        return $this;
    }

    public function getCalories()
    {
        return $this->calories;
    }

    public function toArray()
    {
        return array(
            'name' => $this->getName(),
            'calories' => $this->getCalories(),
        );
    }
}
