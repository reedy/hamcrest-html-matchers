<?php

namespace Bekh6ex\HamcrestHtml\Test;

use Hamcrest\AssertionError;

class FunctionsTest extends \PHPUnit_Framework_TestCase
{

    /**
     * @test
     */
    public function htmlPiece_WhenValidHtmlGiven_DoesNotThrowException()
    {
        $html = '<p></p>';

        assertThat($html, is(htmlPiece()));
    }

    /**
     * @test
     */
    public function htmlPiece_NonHtmlGiven_ThrowsAnException()
    {
        $html = /** @lang text */
            '<p><a></p></a>';

        $this->expectException(AssertionError::class);
        assertThat($html, is(htmlPiece()));
    }


    /**
     * @test
     */
    public function htmlPiece_HasRootElement_DoesNotThrowException()
    {
        $html = '<p></p>';

        assertThat($html, is(htmlPiece(havingRootElement())));
    }

    /**
     * @test
     */
    public function havingRootElement_MultipleRootTags_ThrowsException()
    {
        //TODO Does it make sence?
        $html = '<p></p><p></p>';

        $this->expectException(AssertionError::class);
        assertThat($html, is(htmlPiece(havingRootElement())));
    }

    /**
     * @test
     */
    public function withTagName_RightTagDescriptor_DoesNotThrowException()
    {
        $html = '<p><b></b></p>';

        assertThat($html, is(htmlPiece(havingRootElement(withTagName('p')))));
    }

    /**
     * @test
     */
    public function withTagName_WrongsTagDescriptor_ThrowsException()
    {
        $html = '<p><b></b></p>';

        $this->expectException(AssertionError::class);
        assertThat($html, is(htmlPiece(havingRootElement(withTagName('b')))));
    }

    /**
     * @test
     */
    public function havingDirectChild_HasDirectChild_DoesNotThrowException()
    {
        $html = "<p></p>";

        assertThat($html, is(htmlPiece(havingDirectChild())));
    }

    /**
     * @test
     */
    public function havingDirectChildWithTagName_DoesntHaveDirectChildWithThatTag_ThrowsException()
    {
        $html = "<p></p>";

        $this->expectException(AssertionError::class);
        assertThat($html, is(htmlPiece(havingDirectChild(withTagName('b')))));
    }

    /**
     * @test
     */
    public function nestedHavingDirectChildWithTagName_RightTagName_DoesNotThrowException()
    {
        $html = "<p><b></b></p>";

        assertThat($html, is(htmlPiece(
            havingDirectChild(
                havingDirectChild(withTagName('b'))))));
    }

    /**
     * @test
     */
    public function nestedHavingDirectChildWithTagName_WrongTagName_ThrowsException()
    {
        $html = "<p><b></b></p>";

        $this->expectException(AssertionError::class);
        assertThat($html, is(htmlPiece(
            havingDirectChild(
                havingDirectChild(withTagName('p'))))));
    }

    /**
     * @test
     */
    public function havingDirectChildWithTagName_TargetTagIsNotFirst_FindsIt()
    {
        $html = "<i></i><b></b>";

        assertThat($html, is(htmlPiece(
            havingDirectChild(
                withTagName('b')))));
    }

    /**
     * @test
     */
    public function havingChildWithTagName_TargetTagIsNotFirst_FindsIt()
    {
        $html = "<p><b><i></i></b></p>";

        assertThat($html, is(htmlPiece(
            havingChild(
                withTagName('i')))));
    }

    /**
     * @test
     */
    public function havingChildWithTagName_TargetTagIsAbsent_ThrowsException()
    {
        $html = "<p><b><i></i></b></p>";

        $this->expectException(AssertionError::class);
        assertThat($html, is(htmlPiece(
            havingChild(
                withTagName('br')))));
    }
}
