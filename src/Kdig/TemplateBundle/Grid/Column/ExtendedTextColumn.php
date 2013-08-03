<?php

namespace Kdig\TemplateBundle\Grid\Column;

use APY\DataGridBundle\Grid\Column\Column;
use APY\DataGridBundle\Grid\Filter;

/**
 * Allow strict comparison for selectMulti input
 * Assuming :
 * * result values matches "@@val1@@...@@valN@@" pattern
 * * filter values are sorted (automaticaly done by setValues)
 */
class ExtendedTextColumn extends Column
{
	/**
	 * Allow strict comparison for nlike, eq and new operators
	 */
	public function getFilters($source)
    {
        $filters = array();

        if ($this->hasOperator($this->data['operator'])) {

            switch ($this->data['operator']) {
                case self::OPERATOR_LIKE:
                    if ($this->getSelectMulti()) {
                        $this->setDataJunction(self::DATA_DISJUNCTION);
                    }
                    foreach ((array) $this->data['from'] as $value) {
                        $filters[] = new Filter($this->data['operator'], $value);
                    }
                    break;
                case self::OPERATOR_NLIKE:
                case self::OPERATOR_EQ:
                case self::OPERATOR_NEQ:
                	$val = '';
                    foreach ((array) $this->data['from'] as $value) {
                    	$val .= $value;
                	}
                    $filters[] = new Filter($this->data['operator'], str_replace( '@@@@', '@@', $val));
            }
        }

        return $filters;
    }

    /**
     * Make like and nlike operators availbble as it seems like it works with doctrine >= 2.1.7
     */
    public function getOperators()
    {
        return array_merge(parent::getOperators(), array(self::OPERATOR_LIKE,self::OPERATOR_NLIKE));
    }

    /**
     * Allow easier value usage in template
     * @return array         Array conversion of string "@@val1@@...@@valN@@"
     */
    public function renderCell($value, $row, $router)
    {
        $value = parent::renderCell($value, $row, $router);
        $result = explode("@@", $value);
    	if (count($result) > 1){
	    	unset($result[0]);
	    	unset($result[count($result)]);
    	}
        return $result;
    }

    /**
     * Values has to be sorted to perform strict comparasion
     * "@@val1@@val2@@" == "@@val1@@val2@@" => true
     * "@@val1@@val2@@" == "@@val2@@val1@@" => false
     */
    public function setValues(array $values)
    {
        foreach ($values as $key => $value) {
            $values["@@$key@@"] = $value;
            unset($values[$key]);
        }
        $this->values = $values;
        asort($this->values);
        return $this;
    }

    public function getType()
    {
        return 'extended_text';
    }
}