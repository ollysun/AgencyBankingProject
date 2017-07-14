
<ul>
  
<?
    function loopPath($basename)
    {
        $linkval = '<li><a href="../superadmin/index.php"> Home</a></li>';
        foreach ($basename as $value) {
            $linkval .= "<br><li>" . $value . "</li>";
        }
        
        return $linkval;
    }
?>  
</ul>
    
