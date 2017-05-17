<?php namespace Talba\AuthLib\Traits;

trait HasMessages
{
    protected $message;

    /**
     * Sets message that is going to be displayed as output.
     *
     * @param  string $message
     * @return $this
     */
    public function setMessage($message) {
        $this->message = $message;
        return $this;
    }

    /**
     * Gets the message output.
     *
     * @return string
     */
    public function getMessage() {
        return $this->message;
    }

}
