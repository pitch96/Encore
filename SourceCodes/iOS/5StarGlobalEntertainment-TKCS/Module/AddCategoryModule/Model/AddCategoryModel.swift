//
//  AddCategoryModel.swift
//  5StarGlobalEntertainment-TKCS
//
//  Created by chetu on 03/02/23.
//

import Foundation

struct AddCategoryModel: Codable {
    var statusCode: Int?
    var success: Bool?
    var message: String?
    var data: AddCategoryModelDetail?
}

// MARK: - DataClass
struct AddCategoryModelDetail: Codable {
    var userID: Int?
    var name, updatedAt, createdAt: String?
    var id: Int?

    enum CodingKeys: String, CodingKey {
        case userID = "user_id"
        case name
        case updatedAt = "updated_at"
        case createdAt = "created_at"
        case id
    }
}
