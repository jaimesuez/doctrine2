<?php
/*
 *  $Id$
 *
 * THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS
 * "AS IS" AND ANY EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT
 * LIMITED TO, THE IMPLIED WARRANTIES OF MERCHANTABILITY AND FITNESS FOR
 * A PARTICULAR PURPOSE ARE DISCLAIMED. IN NO EVENT SHALL THE COPYRIGHT
 * OWNER OR CONTRIBUTORS BE LIABLE FOR ANY DIRECT, INDIRECT, INCIDENTAL,
 * SPECIAL, EXEMPLARY, OR CONSEQUENTIAL DAMAGES (INCLUDING, BUT NOT
 * LIMITED TO, PROCUREMENT OF SUBSTITUTE GOODS OR SERVICES; LOSS OF USE,
 * DATA, OR PROFITS; OR BUSINESS INTERRUPTION) HOWEVER CAUSED AND ON ANY
 * THEORY OF LIABILITY, WHETHER IN CONTRACT, STRICT LIABILITY, OR TORT
 * (INCLUDING NEGLIGENCE OR OTHERWISE) ARISING IN ANY WAY OUT OF THE USE
 * OF THIS SOFTWARE, EVEN IF ADVISED OF THE POSSIBILITY OF SUCH DAMAGE.
 *
 * This software consists of voluntary contributions made by many individuals
 * and is licensed under the LGPL. For more information, see
 * <http://www.phpdoctrine.com>.
 */

/**
 * Doctrine_Resource_Collection
 *
 * @author      Konsta Vesterinen <kvesteri@cc.hut.fi>
 * @author      Jonathan H. Wage <jwage@mac.com>
 * @package     Doctrine
 * @license     http://www.opensource.org/licenses/lgpl-license.php LGPL
 * @version     $Revision$
 * @category    Object Relational Mapping
 * @link        www.phpdoctrine.com
 * @since       1.0
 */
class Doctrine_Resource_Collection extends Doctrine_Resource_Access implements Countable, IteratorAggregate
{
    protected $_data = array();
    protected $_config = array();
    protected $_model = null;
    
    public function __construct($model)
    {
        $this->_model = $model;
    }
    
    public function getConfig($key = null)
    {
        return Doctrine_Resource_Client::getInstance()->getConfig($key);
    }
    
    public function count()
    {
        return count($this->_data);
    }
    
    public function get($get)
    {
        if (isset($this->_data[$get])) {
            return $this->_data[$get];
        }
    }

    public function set($set, $value)
    {
        $this->_data[$set] = $value;
    }
    
    public function add($value)
    {
        $this->_data[] = $value;
    }
    
    public function getIterator()
    {
        return new ArrayIterator($this->_data);
    }
    
    public function getFirst()
    {
        return isset($this->_data[0]) ? $this->_data[0]:null;
    }
    
    public function toArray()
    {
        $array = array();
        
        foreach ($this->_data as $key => $record) {
            if ($record->exists()) {
                $array[$this->_model . '_' .$key] = $record->toArray();
            }
        }
        
        return $array;
    }
    
    public function save()
    {
        foreach ($this as $record) {
            $record->save();
        }
    }
}