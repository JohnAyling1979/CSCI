<?php
    class ManageQuote
    {
        var $Qstore;

        public function __construct()
        {
            $this->Qstore=new QuoteStore;
        }

        public function getFinalized()
        {
            return $this->Qstore->getFinalized();
        }

        public function getQuote($quoteId)
        {
            return $this->Qstore->getQuote($quoteId);
        }

        public function getLineItems($quoteId)
        {
            return $this->Qstore->getLineItems($quoteId);
        }

        public function updateQuote($quoteId)
        {
            $this->Qstore->updateQuote($quoteId);
        }

        public function discount($quoteId,$type,$dollar,$percent)
        {
            return $this->Qstore->discount($quoteId,$type,$dollar,$percent);
        }

        public function saction($quoteId)
        {
            $this->Qstore->saction($quoteId);
        }
    }
?>
