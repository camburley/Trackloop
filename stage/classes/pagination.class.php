<?php
 
 
    //Simple pagination class, useful for admin areas for displaying items etc.
    //Written by Andrew Nicholson. April 2008
 
    /* Example usage:
    $query = "SELECT * FROM items ORDER BY id ASC";
    $result = mysql_query($query);
    $total_rows = mysql_num_rows($result);
 
    if(isset($_POST['offset'])) $offset = $_POST["offset"]; else $offset = 1;
 
    $myPagination = new pagination();
    $myPagination->offset = $offset;
    $myPagination->num_per_page = 10;
    $myPagination->num_items = $total_rows;
    $myPagination->url = "my_page.php";
 
    $query = "SELECT * FROM items ORDER BY id ASC LIMIT ".$myPagination->get_start_from().",10";
    $result = mysql_query($query);
    $num_rows = mysql_num_rows($result);
 
    //display stuff//
 
 
    echo($myPagination->get_html_drop_down());
 
    */
    class pagination
    {
        public $offset; 		// The actual page number, first page should be 1 by default.
        public $num_per_page;	// Num items to be shown on each page.
        public $num_items;		// Total Number of items
        public $url;			// Url to post to, usually the filename.
 
 
        public function get_total_pages()
        {
            return ceil($this->num_items / $this->num_per_page);
        }
 
        public function get_start_from()
        {
            return ($this->offset-1) * $this->num_per_page;
        }
 
        public function get_html_drop_down($select_class="", $method="GET", $select_name="offset")
        {
            if($select_class!="")
                $select_class = 'class="'.$select_class.'"';
 
            $html = '<form method="'.$method.'" action="'.$this->url.'">
                <select '.$select_class.' name="'.$select_name.'" onchange="this.form.submit();">';
 
            for($i=1;$i<ceil($this->num_items / $this->num_per_page)+1;$i++)
            {
                if($this->offset==$i)
                    $html .= '<option value="'.$i.'" selected="selected">Page '.$i.' of '.ceil($this->num_items / $this->num_per_page).'</option>';
                 else
                    $html .= '<option value="'.$i.'">Page '.$i.' of '.ceil($this->num_items / $this->num_per_page).'</option>';
            }
 
            $html .='</select></form>';
 
            return $html;
        }
    }
 
 
?>