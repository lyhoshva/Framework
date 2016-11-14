<?php

namespace Framework\Model;

use Doctrine\ORM\EntityRepository;
use Framework\DI\Service;
use Framework\Validation\Validator;

/**
 * Class ActiveRecord
 * @package Framework\Model
 */
abstract class ActiveRecord
{
    /**
     * @var object EntityManager
     */
    private static $em;

    protected $validation_errors = [];

    /**
     * Returns model rules
     *
     * @return array
     */
    public function getRules()
    {
        return [];
    }

    /**
     * Returns Entity className
     *
     * @return string
     */
    public static function className()
    {
        return static::class;
    }

    /**
     * Returns Entity table name
     *
     * @return string
     */
    public static function tableName()
    {
        $em = self::getEntityManager();
        return $em->getClassMetadata(static::className())->getTableName();
    }

    /**
     * @return object EntityManager
     */
    private function getEntityManager()
    {
        if (empty(self::$em)) {
            self::$em = Service::get('doctrine');
        }

        return self::$em;
    }

    /**
     * Returns Repository for the Entity
     *
     * @return EntityRepository
     */
    public static function getRepository()
    {
        return self::getEntityManager()->getRepository(static::className());
    }

    /**
     * Returns Entity by primary key
     *
     * @param $id
     * @return ActiveRecord
     */
    public static function findOne($id)
    {
        $em = self::getEntityManager();
        return $em->find(static::className(), $id);
    }

    /**
     * Validate object
     *
     * @return bool
     */
    public function validate()
    {
        $validator = new Validator($this);
        if ($validator->isValid()) {
            return true;
        } else {
            $this->validation_errors = $validator->getErrors();
            return false;
        }
    }

    /**
     * Return validation errors
     *
     * @return array
     */
    public function getErrors()
    {
        return $this->validation_errors;
    }

    /**
     * Saves record to table
     *
     * @param bool $validate
     * @return bool
     */
    public function persist()
    {
        $em = self::getEntityManager();
        $em->persist($this); //TODO catch exceptions

        return true;
    }
    
    public function flush()
    {
        $em = self::getEntityManager();
        $em->flush();
    }
    
    public function delete()
    {
        $em = self::getEntityManager();
        $em->remove($this);
    }
}
