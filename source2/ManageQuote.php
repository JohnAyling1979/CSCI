<?php
    class ManageQuote
    {
        var $Qstore;

        /*******************************************************************
            FUNCTION:   ManageQuote::connect
            ARGUMENTS:  none
            RETURNS:    none
            USAGE:      creates a QuoteStore object when the controller is 
                        created
        *******************************************************************/
        public function __construct()
        {
            $this->Qstore=new QuoteStore;
        }

        /*******************************************************************
            FUNCTION:   ManageQuote::getFinalized
            ARGUMENTS:  none
            RETURNS:    none
            USAGE:      calls to the quote store to get the finalized quotes
        *******************************************************************/
        public function getFinalized()
        {
            return $this->Qstore->getFinalized();
        }

        /*******************************************************************
            FUNCTION:   ManageQuote::getQuote
            ARGUMENTS:  $quoteId: unique number of the quote
            RETURNS:    an array containing the quote information
            USAGE:      calls to the quote store to get the quotes information
        *******************************************************************/
        public function getQuote($quoteId)
        {
            return $this->Qstore->getQuote($quoteId);
        }

        /*******************************************************************
            FUNCTION:   ManageQuote::getLineItem
            ARGUMENTS:  $quoteId: unique number of the quote
            RETURNS:    a PDO stament containing all the lines
            USAGE:      calls to the quote store to get the lines attached
                        to the quote
        *******************************************************************/
        public function getLineItems($quoteId)
        {
            return $this->Qstore->getLineItems($quoteId);
        }

        /*******************************************************************
            FUNCTION:   ManageQuote::updateQuote
            ARGUMENTS:  $quoteId: unique number of the quote
            RETURNS:    none
            USAGE:      calls to the quote store to update the line items
        *******************************************************************/
        public function updateLineItems($quoteId)
        {
            $this->Qstore->updateLineItems($quoteId);
        }

        /*******************************************************************
            FUNCTION:   ManageQuote::discount
            ARGUMENTS:  $quoteId: unique number of the quote
                        $type: wether a dollar or percent ammount
                        $dollar: dollar value
                        $percent: percent value
            RETURNS:    the new price
            USAGE:      calls to the qoute store to update the price
        *******************************************************************/
        public function discount($quoteId,$type,$dollar,$percent)
        {
            return $this->Qstore->discount($quoteId,$type,$dollar,$percent);
        }

        /*******************************************************************
            FUNCTION:   ManageQuote::saction
            ARGUMENTS:  $quoteId: unique number of the quote
            RETURNS:    none
            USAGE:      calls to the quote store to saction the quotes
        *******************************************************************/
        public function saction($quoteId)
        {
            $this->Qstore->saction($quoteId);
        }
    }
?>
