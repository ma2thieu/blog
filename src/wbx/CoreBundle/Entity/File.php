<?php

namespace wbx\CoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use wbx\FileBundle\Entity\File as wbxFile;

/**
 * @Orm\Entity()
 * @ORM\Table()
 */
class File extends wbxFile {

    public function __toString() {
        return "file";
    }

}