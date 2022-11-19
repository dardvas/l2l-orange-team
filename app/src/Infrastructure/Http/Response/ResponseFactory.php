<?php

namespace App\Infrastructure\Http\Response;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\StreamInterface;
use Zend\Diactoros\Response;
use Zend\Diactoros\Response\HtmlResponse;
use Zend\Diactoros\Response\JsonResponse;
use Zend\Diactoros\Response\RedirectResponse;

class ResponseFactory
{
    private const DEFAULT_JSON_FLAGS = JsonResponse::DEFAULT_JSON_FLAGS | JSON_UNESCAPED_UNICODE;

    public function json($data, array $meta = [], int $status = ResponseCodesDict::HTTP_OK, array $headers = []): ResponseInterface
    {
        return $this->jsonResponse($this->isSuccessStatus($status), $data, $meta, $status, $headers);
    }

    public function jsonData($data, int $status = ResponseCodesDict::HTTP_OK, array $headers = []): ResponseInterface
    {
        return new JsonResponse($data, $status, $headers, self::DEFAULT_JSON_FLAGS);
    }

    protected function jsonResponse(
        bool $success,
        $data = null,
        array $meta = [],
        int $status = ResponseCodesDict::HTTP_OK,
        array $headers = []
    ): ResponseInterface {
        $data = [
            'success' => $success,
            'data'    => $data,
            'meta'    => $meta,
        ];

        return new JsonResponse(
            $data,
            $status,
            $headers,
            self::DEFAULT_JSON_FLAGS
        );
    }

    public function jsonSuccess($data = null, array $meta = [], int $status = ResponseCodesDict::HTTP_OK, array $headers = []): ResponseInterface
    {
        return $this->jsonResponse(true, $data, $meta, $status, $headers);
    }

    public function jsonError($data = null, array $meta = [], int $status = ResponseCodesDict::HTTP_INTERNAL_SERVER_ERROR, array $headers = []): ResponseInterface
    {
        return $this->jsonResponse(false, $data, $meta, $status, $headers);
    }

    public function jsonErrorMessage($message, int $status = ResponseCodesDict::HTTP_INTERNAL_SERVER_ERROR, array $headers = []): ResponseInterface
    {
        return $this->jsonResponse(false, null, [
            'message' => $message,
        ], $status, $headers);
    }

    public function jsonSuccessMessage(string $message, int $status = ResponseCodesDict::HTTP_OK, array $headers = []): ResponseInterface
    {
        return $this->jsonResponse(true, null, [
            'message' => $message,
        ], $status, $headers);
    }

    public function redirect($uri, $status = ResponseCodesDict::HTTP_FOUND, array $headers = []): ResponseInterface
    {
        return new RedirectResponse($uri, $status, $headers);
    }

    public function html($body, $status = ResponseCodesDict::HTTP_OK, array $headers = []): ResponseInterface
    {
        return new HtmlResponse($body, $status, $headers);
    }

    private function isSuccessStatus($statusCode): bool
    {
        return strpos((string) $statusCode, '2') === 0;
    }

    /**
     * @param string|resource|StreamInterface $body Stream identifier and/or actual stream resource
     * @param int $status Status code for the response, if any.
     * @param array $headers Headers for the response, if any.
     * @return ResponseInterface
     * @throws \InvalidArgumentException on any invalid element.
     */
    public function response($body = 'php://memory', $status = ResponseCodesDict::HTTP_OK, array $headers = []): ResponseInterface
    {
        return new Response($body, $status, $headers);
    }

    /**
     * @param int $status
     * @return ResponseInterface
     */
    public function emptyResponse(int $status = ResponseCodesDict::HTTP_OK): ResponseInterface
    {
        return new Response\EmptyResponse($status);
    }

    public function fileResponse($resource, string $mime, int $size, string $fileName): ResponseInterface
    {
        $filename = rawurlencode($fileName);
        $realSize = $this->getRealSizeByResource($resource) ?? $size;

        return $this->response($resource)
            ->withHeader('Content-Type', 'application/force-download')
            ->withHeader('Content-Type', 'application/octet-stream')
            ->withHeader('Content-Type', 'application/download')
            ->withHeader('Content-Type', $mime)
            ->withHeader('Content-Description', 'File Transfer')
            ->withHeader('Content-Transfer-Encoding', 'binary')
            ->withHeader('Content-Length', $realSize)
            ->withHeader('Content-Disposition', "attachment; filename*=UTF-8''$filename")
            ->withHeader('Expires', '0')
            ->withHeader('Cache-Control', 'must-revalidate, post-check=0, pre-check=0')
            ->withHeader('Pragma', 'public');
    }

    private function getRealSizeByResource($resource): ?int
    {
        if ($resource instanceof StreamInterface) {
            return $resource->getSize();
        }

        if (is_resource($resource)) {
            $stats = fstat($resource);

            return $stats['size'] ?? null;
        }

        return null;
    }
}
