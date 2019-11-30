<?php
class Raraunga {
    protected static $tuuhononga;
    
    /**
     * 
     * 
     * 
     */
    public function hono() {
        if ( !isset( self::$tuuhononga ) ) {
            $whiringa           = parse_ini_file( 'raraunga/whiringa_whakapiri.ini' );
            self::$tuuhononga = new mysqli( $whiringa['raraunga_waahitau_tukutuku'], $whiringa['ingoa'], $whiringa['kupuhipa'], $whiringa['ingoa_raraunga'] );
        }
        if ( self::$tuuhononga === false ) {
            return false;
        }
        return self::$tuuhononga;
    }
    
    /**
     *
     *
     *
     *
     */
    public function uiui( $uiui ) {
        $tuuhononga = $this->hono();
        $result = $tuuhononga->query( $uiui );
        return $result;
    }
    
    /**
     *
     *
     *
     *
     */
    public function tiipako( $uiui ) {
        $rows   = array();
        $result = $this->uiui( $uiui );
        if ( $result === false ) {
            return false;
        }
        while ( $row = $result->fetch_assoc() ) {
            $rows[] = $row;
        }
        return $rows;
    }
    
    /**
     *
     * 
     *
     */
    public function hapa() {
        $tuuhononga = $this->hono();
        return $tuuhononga->hapa;
    }
    
    /**
     * 
     *
     * 
     * 
     */
    public function koruki( $uara ) {
        $tuuhononga = $this->hono();
        return "'" . $tuuhononga->real_escape_string( $uara ) . "'";
    }
}
?>