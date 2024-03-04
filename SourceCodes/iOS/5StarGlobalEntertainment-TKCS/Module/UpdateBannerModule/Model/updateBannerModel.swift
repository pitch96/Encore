//
//  updateBannerModel.swift
//  5StarGlobalEntertainment-TKCS
//
//  Created by chetu on 09/03/23.
//

import Foundation
// MARK: Update Banner Model
struct UpdateBannerModel: Codable {
    var statusCode: Int?
    var success: Bool?
    var message: String?
    var data: String?
}
struct GetBannerData: Codable {
    var statusCode: Int?
    var success: Bool?
    var message: String?
    var data: bannerData?
}

// MARK: - bannerData
struct bannerData: Codable {
    var id: Int?
    var description, bannerImage: String?
    var status: Int?
    var deletedAt, createdAt: String?
    var updatedAt: String?

    enum CodingKeys: String, CodingKey {
        case id, description
        case bannerImage = "banner_image"
        case status
        case deletedAt = "deleted_at"
        case createdAt = "created_at"
        case updatedAt = "updated_at"
    }
}
